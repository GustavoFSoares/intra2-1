<template>
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-outline-success" v-bind:class="{ 'active' : data == true }" @click="data = true">
            <input type="radio" name="options"> Sim
        </label>
        <label class="btn btn-outline-danger" v-bind:class="{ 'active' : data == false }" @click="data = false">
            <input type="radio" name="options"> Não
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
    props: ['value'],
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
