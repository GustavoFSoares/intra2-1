<template>
    <div>
        <div id="alert" :class="internClass" role="alert">
            <span v-if="icon"><i :class="icon" aria-hidden="true"></i></span>
            <span style="font-size: 17px">{{ text }}</span>
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
        icon: {default: ''}
    },
    methods: {
        concatClass() {
            $('#alert').show()
            this.internClass = "alert alert-"+this.type+" fade show"
        },
        close() {
            $('#alert').hide()
            this.$emit('close')
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


