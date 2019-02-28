<template>
    <div class="mb-3">
        <div :class="textAlign">
            <label v-if="label" :for="id" v-html="label+':'"> </label>
            <slot>

            </slot>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            textAlign: "text-left",
        }
    },
    props: {
        label: {String, default: false},
        id: String,
        text_left: {Boolean, default: true}
    },
    mounted(){
        this.testAlign()
    },
    methods: {
        testAlign(){
            if(this.text_left == false){
                this.textAlign = ""
            }
        }
    }

}
</script>