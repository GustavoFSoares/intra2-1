<template>
    <div>
        <div :class="internClass" role="alert">
            <span v-if="icon"><i :class="icon" aria-hidden="true"></i></span>
            <span style="font-size: 17px">{{ text }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</template>

<script>
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
            this.internClass = "alert alert-"+this.type+" fade show"
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


