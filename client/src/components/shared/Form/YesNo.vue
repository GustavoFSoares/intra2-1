<template>
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-outline-success" v-bind:class="{ 'active' : data == true, 'disabled': disabled }" @click="data = true">
            <input type="radio" name="options"> {{ yes }}
        </label>
        <label class="btn btn-outline-danger" v-bind:class="{ 'active' : data == false, 'disabled': disabled }" @click="data = false">
            <input type="radio" name="options"> {{ no }}
        </label>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: null
        }
    },
    props: {
        yes: { default: 'Sim' },
        no: { default: 'Não' },
        value: '',
        disabled: { default: false }
    },
    watch: {
        value() {
            this.data = this.value
        },
        data() {
            this.$emit('input', this.data)
            this.$emit('click')
        }
    },
    mounted() {
        this.data = this.value
    },
}
</script>