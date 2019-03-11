<template>
    <icon v-if="value" icon="spinner" spin/>
</template>

<script>
export default {
    props: ['value'],
    watch: {
        value(val) {
            this.$emit('input', val)
        }
    },
}
</script>
