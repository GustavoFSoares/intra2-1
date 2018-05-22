<template>
    <div class="col-md">
        <label v-if="label" :for="id">{{ label }}: </label>
        <slot>
            
        </slot>
    </div>
</template>

<script>
export default {
    props: {
        label: {String, default: false},
        id: String
    },

}
</script>

<style>

</style>


