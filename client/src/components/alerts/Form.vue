<template>
    <div class="container">
        <h1>{{ title }}</h1>

        <row id="title" label="Título">
            <input data-vv-as="Título" v-validate data-vv-rules="required" type="text" class="form-control" name="alert-title" v-model="alert.title">
            <require-text :error="errors.has('alert-title')" :text="errors.first('alert-title')" :show="true" :attribute="alert.title"/>
        </row>

        <row id="content" label="">
            <textarea data-vv-as="Descrição" v-validate data-vv-rules="required|max:250" class="form-control" name="alert-description" cols="30" rows="4" placeholder="Descrição do Alerta: " v-model="alert.description"/>
            <require-text :error="errors.has('alert-description')" :text="errors.first('alert-description')" :show="true" :attribute="alert.text"/>
        </row>

        <div class="row">
            <rows id="enterprise" label="Selecione um Tipo">
                <v-select v-model="alert.type" data-vv-as="Tipo" v-validate data-vv-rules="required" name="alert-type" label="name" :options="options.alerts" @input="changeType"/>
                <require-text :error="errors.has('alert-type')" :text="errors.first('alert-type')" :attribute="alert.type"/>
            </rows>

            <rows>
                <div class="row">
                    <rows label="Horário de Inicio">
                        <date-picker mindate="now" opens="center" id="beginTime">
                            <input v-mask="'##/##/#### - ##:##'" type="text" class="form-control" id="beginTime"/>
                        </date-picker>
                    </rows>
                    <rows label="Horário de Fim">
                        <date-picker mindate="tomorrow" opens="center" id="endTime">
                            <input v-mask="'##/##/#### - ##:##'" type="text" class="form-control" id="endTime"/>
                        </date-picker>
                    </rows>
                </div>
            </rows>
        </div>

        <row>
            <top-alert :id='`${options.typeSelected}-alert`' :title="alert.title" :description="alert.description" :type="options.typeSelected"/>
        </row>

        <row>
            <button class="button btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm">
                Gerar Alerta
            </button>
            <router-link class="button btn btn-outline-primary btn-lg" :to="{name: 'alertas'}" tag="button">
                Voltar
            </router-link>
        </row>
    </div>
</template>

<script>
import Alert, { alertEntity } from "@/entity/alert";
import model from "@/model/alert";
import { VueSelect, TopAlert, DatePicker } from "@/components/shared/Form";
export default {
    data(){
        return {
            id: '',
            title: "Alerta - Adicionar",
            alert: new Alert(),
            options: {
                alerts: alertEntity.getOptions(),
                typeSelected: ' ',
            },
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success? this.submit():"")
        },
        submit() {
            this.alert.beginTime = document.getElementById('beginTime').value
            this.alert.endTime = document.getElementById('endTime').value

            if(model.isEdit(this.id)){
                model.edit(this.id, this.alert).then(() => window.location = `/usuario/alertas` )
            } else {
                model.save(this.alert).then(() => window.location = `/usuario/alertas` )
            }
        },
        loadValues() {
            this.id = this.$route.params.id
            model.getAlert(this.id).then(res => {
                res.type = alertEntity.getSelectedOption(res.type)
                this.alert = res
            })
        },
        changeType() {
            this.alert.type?
                this.options.typeSelected = this.alert.type.value : this.options.typeSelected = " "
        }
    },
    components: {
        'v-select': VueSelect, 
        'top-alert': TopAlert,
        'date-picker': DatePicker,
    },
    mounted() {
        if(model.isEdit(this.$route.params.id)){
            this.loadValues()
        }
    }
}
</script>

<style lang="scss" scoped>
    #warning-alert {
        left: 0;
        padding-right: 54%;
    }

    #danger-alert {
        right: 0;
        padding-left: 54%;
    }    
</style>
