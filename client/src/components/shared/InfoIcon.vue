<template>
    <div>
        <icon id="info-icon" icon="info-circle" class="float-right text-disabled bold" v-tooltip.top="{ 'html': tooltipId }"/>
        <div :id="tooltipId" v-html="message"> </div>
    </div>
</template>

<script>
export default {
    props: {
        message: { default: 'Mensagem' }
    },
    computed: {
        tooltipId() {
            return this._uid+"tooltip-message"
        }
    }
}
</script>

<style scoped>
    #info-icon:hover {
        color: #2c3e50;
    }
</style>
