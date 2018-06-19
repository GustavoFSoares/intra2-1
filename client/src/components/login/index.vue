<template>
    <div class="container">

        <div class="content">

            <div class="row">
                <div class="col-md-6 mb-6 order-md-2">
                    <div id="alert-message">
                        <row v-show="email">
                            <alert-message :text="email.text" :type="email.type"/>
                        </row>
                    </div>

                    <div id="login" @keyup.enter="isValidForm">
                        <row id="id" label="Usuario">
                            <input data-vv-as="Usuário" autocomplete="off" v-validate data-vv-rules="required" type="text" class="form-control" name="id" v-model="login.id">
                            <require-text :error="errors.has('id')" :text="errors.first('id')" :show="true" :attribute="login.id"/>
                            <small class="text-muted">usuario.sobrenome</small>
                        </row>
                        
                        <row id="password" label="Senha">
                            <input data-vv-as="Senha" autocomplete="off" v-validate data-vv-rules="required" type="password" class="form-control" name="password" v-model="login.password">
                            <require-text :error="errors.has('password')" :text="errors.first('password')" :show="true" :attribute="login.password"/>
                        </row>

                        <row>
                            <button @click="isValidForm" id="submit" class="btn btn-outline-primary btn-lg" :disabled="sending">
                                <i v-show="sending" class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                                Login
                            </button>
                        </row>
                    </div>
                </div>

                <div class="col-md-6 order-md-1">
                    <div id="logo-canoas">
                        <img src="@/../static/img/logo-canoas.jpg" alt="Logo Canoas">
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
import { FormRw, FormRws, Require } from '@/components/shared/Form';
import Mail, { LoginStatus } from "@/entity/AlertMessage";
import AlertMessage from "@/components/shared/AlertMessage";
import model from '@/model/login-model';
export default {
    data() {
        return {
            login: {
                id: '',
                password: ''
            },
            email: '',
            sending: false
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success? this.submit():"")
        },
        submit() {
            this.sending = true
            model.doLogin(this.login).then(res => {

                this.email = new Mail()
                if(res.status) {
                    this.$session.start()
                    this.$session.set('user', res.user)

                    this.sending = false
                    this.email = LoginStatus.success
                    
                    setTimeout(() => {
                        
                        if (window.lastRouteAccess) {
                            window.location = window.lastRouteAccess
                        } else {
                            window.location = '/usuario'
                        }
                    }, 1000);
                } else {
                    this.sending = false

                    this.email.type = LoginStatus.failed.type
                    this.email.text = res.message
                }

            })
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'require-text': Require,
        'alert-message': AlertMessage,
    }, 
    mounted() { }
}
</script>

<style scoped>
    .content {
        margin-top: 5%;
    }

    .buttons {
        margin-left: -15%
    }
    
    #submit {
        margin-left: 45%;
    }

    small {
        text-align: center;
    }

    img {
        width: 100%;
        height: 100%;
    }

</style>
