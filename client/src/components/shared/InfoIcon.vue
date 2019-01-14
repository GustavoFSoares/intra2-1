<template>
    <div>
        <icon id="info-icon" icon="info-circle" class="float-right text-disabled" v-tooltip.top="{ 'html': 'tooltip-message' }"/>
        <div id="tooltip-message" v-html="message"> </div>
    </div>
</template>

<script>
export default {
    props: {
        message: { default: 'Mensagem' }
    }
}
</script>

<style scoped>
    #info-icon:hover {
        color: #2c3e50;
    }
</style>
