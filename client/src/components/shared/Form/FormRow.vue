<template>
    <div class="mb-3">
        <div class="text-left">
            <label v-if="label" :for="id">{{ label }}: </label>
            <slot>

            </slot>
        </div>
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


