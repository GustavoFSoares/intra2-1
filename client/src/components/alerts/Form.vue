<template>
    <div class="container">
        <h1>{{ title }}</h1>

        <row id="title" label="Título">
            <input data-vv-as="Título" v-validate data-vv-rules="required" type="text" class="form-control" name="alert-title" v-model="alert.title">
            <require-text :error="errors.has('alert-title')" :text="errors.first('alert-title')" :show="true" :attribute="alert.title"/>
        </row>

        <row id="content" label="">
            <textarea data-vv-as="Descrição" v-validate data-vv-rules="required|max:115" class="form-control" name="alert-description" cols="30" rows="4" placeholder="Descrição do Alerta: " v-model="alert.description"/>
            <require-text :error="errors.has('alert-description')" :text="errors.first('alert-description')" :show="true" :attribute="alert.text"/>
        </row>

        <row id="enterprise" label="Selecione um Tipo">
            <v-select v-model="alert.type" data-vv-as="Tipo" v-validate data-vv-rules="required" name="alert-type" label="name" :options="options.alerts"/>
            <require-text :error="errors.has('alert-type')" :text="errors.first('alert-type')" :attribute="alert.type"/>
        </row>

        <row>
            <top-alert :id='`${alert.type.value}-alert`' :title="alert.title" :description="alert.description" :type="alert.type.value"/>
        </row>

        <row>
            <button class="button btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm">
                Gerar Alerta
            </button>
            <router-link class="button btn btn-outline-primary btn-lg" to="/alertas" tag="button">
                Voltar
            </router-link>
        </row>
    </div>
</template>

<script>
import { Alert, alertOptions } from "@/entity";
import model from "@/model/alert";
import { FormRw, FormRws, Require, VueSelect, TopAlert } from "@/components/shared/Form";
export default {
    data(){
        return {
            id: '',
            title: "Alerta - Adicionar",
            alert: new Alert(),
            options: {
                alerts: 
                    [ { name: "Aviso", value: "warning" },
                    { name: "Erro", value: "danger" }, ]
            },
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success? this.submit():"")
        },
        submit() {
            if(model.isEdit(this.id)){
                model.edit(this.id, this.alert).then(res => window.location = "http://localhost/alertas" )
            } else {
                model.save(this.alert).then(res => window.location = "http://localhost/alertas" )
            }
        },
        loadValues() {
            this.id = this.$route.params.id
            model.getAlert(this.id).then(res => {
                res.type = alertOptions(res.type)
                this.alert = res
            })
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'require-text': Require,
        'v-select': VueSelect, 
        'top-alert': TopAlert,
    },
    mounted() {
        if(model.isEdit(this.$route.params.id)){
            this.loadValues()
        }
    }
}
</script>

<style scoped>
    #warning-alert {
        left: 0;
        padding-right: 54%;
    }

    #danger-alert {
        right: 0;
        padding-left: 54%;
    }    
</style>
