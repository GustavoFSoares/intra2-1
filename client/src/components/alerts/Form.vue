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
            <v-select v-model="alert.type" data-vv-as="Tipo" v-validate data-vv-rules="required" name="alert-type" label="name" :options="options.alerts"  @input="loadstyle"/>
            <require-text :error="errors.has('alert-type')" :text="errors.first('alert-type')" :attribute="alert.type"/>
        </row>

        <row>
            <top-alert :id="alert.id" :title="alert.title" :description="alert.description" :type="alert.type.value"/>
        </row>

        <row>
            <button class="button btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm">
                Gerar Alerta
            </button>
        </row>

    </div>
</template>

<script>
import { FormRw, FormRws, Require, VueSelect, TopAlert } from "@/components/shared/Form";
export default {
    data(){
        return {
            title: "Alerta - Adicionar",
            alert: {
                title: '',
                description: '',
                type: '',
                id: ''
            },
            options: {
                alerts: 
                    [ { name: "Aviso", value: "warning" },
                    { name: "Erro", value: "danger" }, ]
            },
            style: {
                id: '',
                border: '',
                title: ''
            }
        }
    },
    methods: {
        loadstyle() {
            this.alert.id = this.alert.type.value+"-alert"
        },
        isValidForm() {
            this.$validator.validateAll().then(success => success? alert("Validou"):"")
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'require-text': Require,
        'v-select': VueSelect, 
        'top-alert': TopAlert,
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
