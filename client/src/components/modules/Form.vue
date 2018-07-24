<template>
    <div class="container" @keyup.enter="isValidForm">
        <h1>{{ title }}</h1>

        <row id="name" label="Nome">
            <input data-vv-as="Nome" v-validate data-vv-rules="required" type="text" class="form-control" name="module-title" v-model="Module.name">
            <require-text :error="errors.has('module-title')" :text="errors.first('module-title')" :show="true" :attribute="Module.name"/>
        </row>

        <div class="row">
            
            <rows id="route" label="Rota">
                <div class="input-group">
                    <input @keyup.enter="routeExists()" data-vv-as="Rota" v-validate data-vv-rules="required" type="text" class="form-control" name="module-route" v-model="Module.routeName" :placeholder="path+'/usuario/'">
                    <div class="input-group-append">
                        <button @click="routeExists()" type="button" class="btn btn-secondary">
                            <icon icon="sync"/>
                        </button>
                    </div>
                </div>

                <div id="exposed-route" v-if="route.show">
                    <router-link :to="{name: route.name}" v-if="route.exist">
                        <small>{{ route.name }}</small>
                    </router-link>
                    <small class="text-danger" v-else>{{ route.notfound }}</small>
                </div>
                
                <require-text :error="errors.has('module-route')" :text="errors.first('module-route')" :show="true" :attribute="Module.routeName"/>
            </rows>

            <rows label="Icone">
                <div class="row">
                    <rows>
                        <input data-vv-as="Icone" v-validate data-vv-rules="required" type="text" class="form-control" name="module-icon" v-model="Module.icon">
                    </rows>
                    <rows>
                        <div class="row">
                            <icon v-if="Module.icon" id="icon-module" :icon="Module.icon"/>
                        </div>
                    </rows>
                </div>
                
                <div id="font-awesome">
                    <a href="https://fontawesome.com/" target="_blank">
                        <small>Font-Awesome</small>
                    </a>
                </div>
                
                <require-text :error="errors.has('module-icon')" :text="errors.first('module-icon')" :show="true" :attribute="Module.icon"/>
            </rows>
        </div>

        <row label="Padrão">
            <input type="checkbox" v-model="Module.default">
        </row>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm">
                    Gerar Modulo
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'modulos'}" tag="button">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import Module from "@/entity/Module";
import model, { getter } from "@/model/modules-model";
import { FormRw, FormRws, Require } from "@/components/shared/Form";

export default {
    data(){
        return {
            id: '',
            title: "Adicionar Modulo",
            path: window.location.origin,
            route: {
                show: false,
                exist: false,
                notfound: 'Rota não encontrada'
            },
            Module: new Module(),
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success && this.routeExists() ? this.submit():"")
        },
        submit() {
            if(model.isEdit(this.id)){
                model.doEditModule(this.id, this.Module).then(() => this.$router.go('-1') )
            } else {
                 model.doAddModule(this.Module).then(() => this.$router.go('-1'))
            }
        },
        loadValues() {
            this.id = this.$route.params.id
            getter.getModuleById(this.id).then(res => {
                this.Module = new Module(res)
            })
        },
        routeExists() {
            let route = this.$router.resolve({name: this.Module.routeName})
            
            if(route && route.href !== '/'){
                this.route.exist = true
                this.route.name = route.location.name
            } else {
                this.route.exist = false
            }
            this.route.show = true
            return this.route.exist
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
    #icon-module {
        font-size: 200%;
    }

    #buttons {
        margin-top: 5%;
    }
</style>
