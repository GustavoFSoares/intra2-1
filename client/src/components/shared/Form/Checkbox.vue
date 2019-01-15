<template>
        <label class="switch">
            <input :id="id" @click="change()" type="checkbox" v-model="value" :disabled="disabled">
            <span class="slider round"></span>
        </label>
</template>

<script>
export default {
    data() {
        return { 
            value: ''
        }
    },
    props: {
        checked: Boolean,
        id: '',
        disabled: { default: false },
    },
    methods: {
        change(){
            this.$emit('changed')
        }
    },
    mounted(){
        this.value = this.$props.checked
    }
}
</script>


<style scoped>
    .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 30px;
    }

    .switch input {display:none;}

    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 23px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }

    input:checked + .slider {
    background-color: #2196F3;
    }
    
    input:checked:disabled + .slider {
    background-color: rgb(170, 216, 253);
    }

    input:disabled + .slider {
        background-color: #bfbfbf61;
    }

    input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
    border-radius: 50%;
    }

    label {
        display: inline-block;
        margin-bottom: 0;
    }


</style>
