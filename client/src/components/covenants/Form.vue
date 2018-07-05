<template>
    <div class="container">
        <h1>{{ title }}</h1>

        <row id="name" label="Nome">
            <input data-vv-as="Nome" v-validate data-vv-rules="required" type="text" class="form-control" name="covenant-title" v-model="covenant.title">
            <require-text :error="errors.has('covenant-title')" :text="errors.first('covenant-title')" :show="true" :attribute="covenant.title"/>
        </row>

        <div id="link">
            <label>Link:</label>
            <div class="row">
                
                <rows id="link">
                    <div class="input-group">
                        <input @keyup.enter="linkExists()" data-vv-as="Link" v-validate data-vv-rules="required" type="text" class="form-control" name="covenant-link" v-model="covenant.link" placeholder="https://">
                        <button @click="linkExists()" type="button" class="btn btn-secondary">
                            <div class="input-group-append">
                                <i class="fa fa-refresh"></i>
                            </div>
                        </button>
                    </div>

                    <require-text :error="errors.has('covenant-link')" :text="errors.first('covenant-link')" :show="true" :attribute="covenant.link"/>
                </rows>

                <rows>
                    <div class="form-control" id="exposed-route" v-if="link.show">
                        <a :href="link.name" v-if="link.exist">
                            <span>{{ link.name }}</span>
                        </a>
                        <span class="text-danger" v-else>{{ link.notfound }}</span>
                    </div>
                </rows>
            </div>
        </div>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm">
                    Cadastrar Convênio
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'convenios'}" tag="button">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import Covenant from "@/entity/Covenant";
import model, { getter } from "@/model/covenants-model";
import { FormRw, FormRws, Require } from "@/components/shared/Form";

export default {
    data(){
        return {
            id: '',
            title: "Adicionar Modulo",
            link: {
                show: false,
                exist: false,
                notfound: 'Link não encontrado'
            },
            covenant: new Covenant()
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success && this.linkExists() ? this.submit():"")
        },
        submit() {
            if(model.isEdit(this.id)){
                model.doEditCovenant(this.id, this.covenant).then(() => this.$router.go('-1') )
            } else {
                 model.doAddCovenant(this.covenant).then(() => this.$router.go('-1'))
            }
        },
        loadValues() {
            this.id = this.$route.params.id
            getter.getCovenantById(this.id).then(res => {
                this.covenant = new Covenant(res)
            })
        },
        linkExists() {
            this.link.exist = false

            if(this.covenant.link && this.covenant.link.substring(0, 4) == 'http'){
                this.link.exist = true
                this.link.name = this.covenant.link
            } else {
                this.link.exist = false
            }
            this.link.show = true
            return this.link.exist
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'require-text': Require,
    },
    mounted() {
        this.loadValues()
    }
}
</script>

<style scoped>
    #icon-covenant {
        font-size: 200%;
    }

    #buttons {
        margin-top: 5%;
    }
</style>
