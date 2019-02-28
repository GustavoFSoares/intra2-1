<template>
    <div class="container" @keyup.enter="isValidForm">
        <h1>{{ title }}</h1>

        <div class='row'>
            <rows label='Módulo Pai'>
                <input type="radio" name="tipo" :value="false" v-model="isChield">
            </rows>
            
            <rows label='Módulo Filho'>
                <input type="radio" name="tipo" :value="true" v-model="isChield">
            </rows>
        </div>

        <row id="name" :label="subtitles.name">
            <input :data-vv-as="subtitles.name" v-validate data-vv-rules="required" type="text" class="form-control" name="module-title" v-model="Module.name">
            <require-text :error="errors.has('module-title')" :text="errors.first('module-title')" :show="true" :attribute="Module.name"/>
        </row>

        <row id="father" :label='subtitles.father' v-if="isChield">
            <v-select :data-vv-as="subtitles.father" v-validate data-vv-rules="required" label="name" :options="values.modules" name="modules-father" v-model="Module.parent"/>
            <require-text :error="errors.has('modules-father')" :text="errors.first('modules-father')" :show="true" :attribute="values.modules"/>
        </row>

        <row :label='subtitles.children' v-if="!isChield && Module.children" class="container">
            <div v-for="(chield, index) in Module.children" :key="index" class="list-group  list-group-flush ">
                <div class="list-group-item" v-bind:class="{ 'list-group-item-danger': chield.c_removed }">
                    <div class='row'>
                        <div class="col text-left">
                            <icon :icon="chield.icon"/> {{ chield.name }}
                        </div>
                        
                        <div class="col text-right">
                            <router-link @click.native="removeChield(chield.id)" to="">
                                <icon icon="trash-alt" class="text-danger"/>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </row>

        <div class="row">
            <rows id="route">

                <div v-if="!Module.children || isChield">
                    <label>{{subtitles.route}}</label>

                    <div class="input-group">
                        <input @keyup.enter="routeExists()" :data-vv-as="subtitles.route" v-validate data-vv-rules="required" type="text" class="form-control" name="module-route" v-model="Module.routeName" :placeholder="path+'/usuario/'">
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
                </div>

            </rows>

            <rows :label="subtitles.icon">
                <div class="row">
                    <rows>
                        <input :data-vv-as="subtitles.icon" v-validate data-vv-rules="required" type="text" class="form-control" name="module-icon" v-model="Module.icon">
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

        <row :label="subtitles.default">
            <input type="checkbox" v-model="Module.default">
        </row>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm">
                    Gerar Módulo
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
import { FormRw, FormRws, Require, VueSelect } from "@/components/shared/Form";

export default {
    data(){
        return {
            id: '',
            title: "Adicionar Módulo",
            path: window.location.origin,
            isChield: false,
            route: {
                show: false,
                exist: false,
                notfound: 'Rota não encontrada'
            },
            Module: new Module(),
            values: {
                modules: [ { name: ''} ]
            },
            subtitles: {
                name: "Nome",
                father: "Módulo Pai",
                children: "Filhos",
                icon: "Icone",
                route: "Rota",
                default: "Padrão",
            },
            father: '',
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success && this.routeExists() ? this.submit():"")
        },
        submit() {
            if(this.isChield) {
                if(model.isEdit(this.id)){
                    model.doEditChieldModule(this.id, this.Module).then(() => this.$router.go('-1') )
                } else {
                    model.doAddChieldModule(this.Module).then(() => this.$router.go('-1'))
                }
            } else {
                delete this.Module.parent
                delete this.Module.children

                if(model.isEdit(this.id)){
                    model.doEditModule(this.id, this.Module).then(() => this.$router.go('-1') )
                } else {
                    model.doAddModule(this.Module).then(() => this.$router.go('-1'))
                }
            }
        },
        removeChield(chieldId) {
            model.doRemoveChieldModule(chieldId).then(res => this.$router.go())
        },
        loadValues() {
            this.id = this.$route.params.id
            getter.getModuleById(this.id).then(res => {
                this.Module = new Module(res)
                this.isChield = res.parent ? true : false
            })
            getter.getModules().then(res => this.values.modules = res)
        },
        routeExists() {
            if(!this.isChield) {
                return true
            }

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
        'v-select': VueSelect,
    },
    mounted() {
        this.loadValues()
    }
}
</script>

<style lang="scss" scoped>
    #icon-module {
        font-size: 200%;
    }

    #buttons {
        margin-top: 5%;
    }
</style>
