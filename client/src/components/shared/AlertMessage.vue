<template>
    <div>
        <div id="alert" :class="internClass" role="alert">
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
        text: String,
        type: String,
        icon: {default: ''},
        timeout: {default: 3500}
    },
    methods: {
        concatClass() {
            $('#alert').fadeIn()
            this.internClass = "alert alert-"+this.type+" fade show"
            setTimeout(() => {
                $('#alert').fadeOut()
            }, this.timeout);
        },
        close() {
            $('#alert').fadeOut()
            this.$emit('close')
        },
        show() {
            console.log('show');
            
            $("#alert").fadeIn()
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


