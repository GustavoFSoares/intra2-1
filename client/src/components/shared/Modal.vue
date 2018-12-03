<template>
    <div id="all-modal">
        <div class="modal fade" :id="id" tabindex="-1" role="dialog" :aria-labelledby="id" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
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

</template>
<script>
import $ from "jquery";
export default {
    props: {
        title: String,
        submitlabel: {type: String, default: 'Ok'},
    },
    data() {
        return {
            id: '',
        }
    },
    methods: {
        send() {
            this.$emit('return')
            $(`#${this.id}`).modal('hide')
        },
        show() {
            $(`#${this.id}`).modal('show')
        }
    },
    created() {
        let space = /\s/g;
        if(this.title) {
            this.id=this.title.replace(space, "")
        } else {
            this.id = 'modal'
        }
        
    }
}
</script>
