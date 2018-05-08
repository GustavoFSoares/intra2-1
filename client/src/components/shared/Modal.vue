<template>
    <div id="all-modal">
        <div class="modal fade" id="content-modal" tabindex="-1" role="dialog" aria-labelledby="content-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{title}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <slot>

                        </slot>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" @click="send">{{submitlabel}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Component Father -->
    <!-- <modal title="E-mail" submitlabel="Enviar Email" @modal-close="isValidateForm">
            <div class="float-right">
                Enviar Anonimamente: 
                <input type="checkbox" v-model="report.reporter.anonymous">
            </div>
            <row label="E-mail">
                <input class="form-control" type="text" v-model="report.reporter.email">
            </row>
            <row label="Senha">
                <input class="form-control" type="password" v-model="report.reporter.password">
            </row>
            <row></row>
        </modal> -->
</template>
<script>
import $ from "jquery";
export default {
    props: {
        title: String,
        submitlabel: {type: String, default: 'Ok'},
    },
    methods: {
        send(){
            this.$emit('modal-close')
            $('#content-modal').modal('hide')
        },
    }
}
</script>
