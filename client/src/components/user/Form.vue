<template>
    <div id="form-edit" class="container" @keyup.enter="isValidForm">
        <h1>{{ title }}</h1>

        <div class='row'>
            <rows label='Nome' class="col-md-5">
                <input data-vv-as="Nome" v-validate data-vv-rules="required" type="text" class="form-control" name="User-title" v-model="User.name">
                <require-text :error="errors.has('User-title')" :text="errors.first('User-title')" :show="true" :attribute="User.name"/>
            </rows>
            <rows label='E-mail'>
                <input data-vv-as="Email" v-validate data-vv-rules="email" type="text" class="form-control" name="User-email" v-model="User.email">
                <require-text :error="errors.has('User-email')" :text="errors.first('User-email')" :show="true" :attribute="User.email"/>
            </rows>
        </div>

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
            <rows label="Usuário Ativo">
                <br>
                <checkbox id="removed" class="button" v-model="User.active"/>
            </rows>

            <rows label="Level">
                <div class="level">
                    <router-link class="level-plus" to="" id="icon" v-if="User.level < 3" @click.native="User.level++" :disabled="!userSession.admin">
                        <icon icon="plus"/> 
                    </router-link>
                    
                    <span id="level">{{ User.level }}</span>
                    
                    <router-link class="level-minus" to="" id="icon" v-if="User.level > 1" @click.native="User.level--" :disabled="!userSession.admin"> 
                        <icon  icon="minus"/>
                    </router-link>
                </div>
            </rows>
            
            <rows label="Administrador">
                <br>
                <checkbox id="admin" class="button" v-model="User.admin" :disabled="!userSession.admin"/>
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
                <button v-if="!doNotPermission" class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm" :disabled="sending">
                    Editar
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'usuarios/gerenciador'}" tag="button" :disabled="sending">
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

export default {
    data(){
        return {
            id: this.$route.params.id,
            title: "Editar Usuário",
            User: new User(),
            userSession: $session.get('user'),
            sending: false,
            doNotPermission: true
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success  ? this.submit():"")
        },
        submit() {
            this.sending = true
            model.doEditUser(this.id, this.User).then(() => {
                this.sending = false
                this.$alert.success('Usuario Editado')

                this.updatindUser(this.User)
                this.$router.push('/usuario/gerenciador')
            }, err => {
                this.sending = false
                this.$alert.danger('Erro ao Atualizar')
            })
        },
        loadValues() {
            getter.getUserById(this.id).then(res => {
                if(this.userSession.id == res.id || this.userSession.admin) {
                    this.User = new User(res)

                    this.doNotPermission = false
                } else {
                    this.$alert.info('Você não tem permissão para editar esse usuário')
                }
                
            })
        },
        updatindUser(user) {
            if(this.userSession.id == user.id ) {
                this.$session.set('user', user)
                this.$emit('rootEvent', user)
            }
        }
    },
    components: {
        'checkbox': Checkbox,
    },
    mounted() {
        this.loadValues()
    },
}
</script>

<style scoped>
    #form-edit {
        height: 100%; 
        width: 100%;  
        overflow-y: hidden;
    }

    #buttons {
        margin-top: 5%;
    }

    #icon {
        margin-left: 10px;
        margin-right: 10px;
    }

    .level .level-plus[disabled], .level-minus[disabled] {
        pointer-events: none;
        color: #007bff7d;
    }

</style>
