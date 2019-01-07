<template>
    <div>
        <div :id="id" :class="internClass" role="alert">
            <span v-if="icon"><i :class="icon" aria-hidden="true"></i></span>
            <span style="font-size: 17px" v-html="text"></span>
            <button type="button" class="close" @click="close()">
                <span>&times;</span>
            </button>
        </div>
    </div>
</template>

<script>
import $ from 'jquery';
export default {
    data() {
        return {
            internClass: '',
        }
    },
    props: {
        id: {default: 'alert-message'},
        text: String,
        type: String,
        icon: {default: ''},
        timeout: {default: 3500}
    },
    methods: {
        concatClass() {
            this.internClass = "alert alert-"+this.type+" fade show"
        },
        close() {
            $('#'+this.id).fadeOut()
            this.$emit('close')
        },
        show() {
            $('#'+this.id).fadeIn()
            setTimeout(() => {
                this.close()
            }, this.timeout);
        }
    },
    mounted(){
        this.concatClass()
    },
    updated(){
        this.concatClass()
    }
}
</script>


