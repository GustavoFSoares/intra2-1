<template>
    <div class="container">
        
        <div class="content">
            <div class="row">

                <div class="col-md-6 mb-6 order-md-2">
                    <div id="login">
                        <row id="id" label="Usuario">
                            <input data-vv-as="Nome" autocomplete="off" v-validate data-vv-rules="required" type="text" class="form-control" name="name">
                            <small class="text-muted">usuario.sobrenome</small>
                        </row>
                        
                        <row id="password" label="Senha">
                            <input data-vv-as="Nome" autocomplete="off" v-validate data-vv-rules="required" type="password" class="form-control" name="name">
                        </row>

                        <row>
                            <button @click="login" id="submit" class="btn btn-outline-primary btn-lg">Login</button>
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
import model from '@/model/login-model';
export default {
    data() {
        return { }
    },
    methods: {
        login() {
            model.login()
        },
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
    }
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
