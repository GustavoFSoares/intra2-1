<template>
    <div class="container" @keyup.enter="isValidForm">
        <h1>{{ title }}</h1>

        <row :label="subtitles.id" v-if="link.id" class="row col-md-2">
            <input type="text" class="form-control" name="Link-id" v-model="link.id" disabled>
        </row>

        <div class="row">
            <rows :label="subtitles.title" class="col-md-3">
                <input :data-vv-as="subtitles.title" v-validate data-vv-rules="required" type="text" class="form-control" name="Link-title" v-model="link.title">
                <require-text :error="errors.has('Link-title')" :text="errors.first('Link-title')" :attribute="link.title"/>
            </rows>
            
            <rows>
                <div class='row url'>
                    <rows :label="subtitles.url">
                        <input :data-vv-as="subtitles.url" v-validate data-vv-rules="required" type="text" class="form-control" name="Link-url" v-model="link.url">
                    </rows>

                    <rows class="demonstration" >
                        <a :href="link.url" target='_blank'>{{ link.url }}</a>
                    </rows>
                </div>
                <require-text :error="errors.has('Link-url')" :text="errors.first('Link-url')" :show="true" :attribute="link.url"/>
            </rows>
        </div>

        <div class='row'>
            <rows label='Link Externo' class="col-md-3">
                <br>
                <checkbox v-model="link.externalLink"/>
            </rows>
            
            <rows label='Imagem'>
                <image-uploader v-model="link.icon" :imageName="link.title" :submit_method="saveImage"/>
            </rows>
        </div>

        <div class="mt-3">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm" :disabled="sending">
                    Cadastrar Link <icon icon="spinner" spin v-if="sending"/>
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'link'}" tag="button" :disabled="sending">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import { Checkbox } from "@/components/shared/Form";
import ImageUploader from "@/components/shared/ImageUploader";

import model, { getter } from "@/model/link-model";
import Link from "@/entity/Link";

export default {
    data(){
        return {
            id: '',
            title: "Cadastro de Link",
            link: new Link(),
            subtitles: {
                id: "Id",
                title: "Título",
                url: "Url",
                icon: "Imagem",
                externalLink: "Externo à Aplicação",
            },
            sending: false,
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success ? this.submit():"")
        },
        submit() {
            this.sending = true
            if(this.isEdit(this.id)){
                model.doUpdate(this.id, this.link).then(res => {
                    this.$router.push( {name: 'link'} )
                }).catch(err => {
                    this.sending = false
                })
            } else {
                model.doInsert(this.link).then(res => { 
                    this.$router.push( {name: 'link'} )
                }).catch(err => {
                    this.sending = false
                })
            }
        },
        loadValues() {
            this.id = this.$route.params.id
            if(this.isEdit()) {
                getter.getLinkById(this.id).then(res => {
                    this.link = new Link(res)
                })
            }
        },
        isEdit() {
            return model.isEdit(this.id)
        },
        saveImage: model.saveImage,
    },
    components: {
        'checkbox': Checkbox,
        'image-uploader': ImageUploader,
    },
    mounted() {
        this.loadValues()
    },
}
</script>

<style lang="scss" scoped>
    .url {
        display: flex;
        align-items: center;

        .demonstration {
            text-align: left;
        }
    }
</style>
