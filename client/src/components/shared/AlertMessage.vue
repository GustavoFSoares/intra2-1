<template>
    <div>
        <div :class="internClass" role="alert">
            {{ text }}
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
        type: String
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


