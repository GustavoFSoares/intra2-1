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
                        <slot name="content">

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
