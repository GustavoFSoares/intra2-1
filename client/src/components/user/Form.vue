<template>
    <div class="container" @keyup.enter="isValidForm">
        <h1>{{ title }}</h1>

        <row id="name" label="Nome">
            <input data-vv-as="Nome" v-validate data-vv-rules="required" type="text" class="form-control" name="User-title" v-model="User.name">
            <require-text :error="errors.has('User-title')" :text="errors.first('User-title')" :show="true" :attribute="User.name"/>
        </row>

        <div class="row">
            <rows label="id" class="mb-3">
                <input data-vv-as="ID" v-validate data-vv-rules="required" type="text" class="form-control" disabled name="User-id" v-model="User.id">
                <require-text :error="errors.has('User-id')" :text="errors.first('User-id')" :show="true" :attribute="User.id"/>
            </rows>
            
            <rows label="Cargo" class="mb-3">
                <input data-vv-as="Cargo" v-validate data-vv-rules="required" type="text" class="form-control" disabled name="User-occupation" v-model="User.occupation">
                <require-text :error="errors.has('User-occupation')" :text="errors.first('User-occupation')" :show="true" :attribute="User.occupation"/>
            </rows>
           
            <rows label="Ramal">
                <input data-vv-as="Ramal" v-validate data-vv-rules="required" type="text" class="form-control" name="User.ramal" v-model="User.ramal">
                <require-text :error="errors.has    ('User.ramal')" :text="errors.first('User.ramal')" :show="true" :attribute="User.ramal"/>
            </rows>
        </div>
       
        <div class="row mb-3">
            <rows label="Usuário Removido">
                <br>
                <checkbox @changed="User.c_removed = !User.c_removed" id="removed" class="button" :checked="User.c_removed"/>
            </rows>

            <rows label="Level">
                <div>
                    <router-link to="" id="icon" v-if="User.level < 3" @click.native="User.level++">
                        <icon icon="plus"/> 
                    </router-link>
                    
                    <span id="level">{{ User.level }}</span>
                    
                    <router-link to="" id="icon" v-if="User.level > 1" @click.native="User.level--"> 
                        <icon  icon="minus"/>
                    </router-link>
                </div>
            </rows>
            
            <rows label="Administrador">
                <br>
                <checkbox @changed="User.admin = !User.admin" id="admin" class="button" :checked="User.admin"/>
            </rows>
        </div>

        <!-- <row label="Grupo">
            <input data-vv-as="Grupo" v-validate data-vv-rules="required" type="text" class="form-control" disabled name="User-group" v-model="User.group.name">
            <require-text :error="errors.has('User-group')" :text="errors.first('User-group')" :show="true" :attribute="User.group.name"/>
        </row> -->

        <div class="row">
            <rows label="Grupo">
                <input data-vv-as="Grupo" v-validate data-vv-rules="required" type="text" class="form-control" disabled name="User-group" v-model="User.group.name">
                <require-text :error="errors.has('User-group')" :text="errors.first('User-group')" :show="true" :attribute="User.group.name"/>
            </rows>
            
            <rows label="Unidade">
                <input data-vv-as="Unidade" v-validate data-vv-rules="required" type="text" class="form-control" disabled name="User-group" v-model="User.group.enterprise">
                <require-text :error="errors.has('User-group')" :text="errors.first('User-group')" :show="true" :attribute="User.group.enterprise"/>
            </rows>
        </div>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm">
                    Editar
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'usuarios/gerenciador'}" tag="button">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import User from "@/entity/User";
import { Checkbox } from "@/components/shared/Form";
import model, { getter } from "@/model/user-model";
import { FormRw, FormRws, Require } from "@/components/shared/Form";

export default {
    data(){
        return {
            id: '',
            title: "Editar Usuário",
            User: new User()
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success  ? this.submit():"")
        },
        submit() {
            model.doEditUser(this.id, this.User).then(() => this.$router.go('-1') )
        },
        loadValues() {
            this.id = this.$route.params.id
            getter.getUserById(this.id).then(res => {
                this.User = new User(res)
                
                document.getElementById('admin').checked = this.User.admin
                document.getElementById('removed').checked = this.User.c_removed
            })
        },
        clicou() {
            
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'require-text': Require,
        'checkbox': Checkbox,
    },
    mounted() {
        this.loadValues()
    },
}
</script>

<style scoped>
    #buttons {
        margin-top: 5%;
    }

    #icon {
        margin-left: 10px;
        margin-right: 10px;
    }

</style>
