<template>
    <div>
        <div @click="click()" id="info-icon-content">
            <icon id="info-icon" icon="info-circle" class="text-disabled bold" v-tooltip.top="'Informações'"/>
            <div v-show="false" ref="content">
                <slot >
                
                </slot>
            </div>
        </div>
    </div>
</template>

<script>
import Alert from "@/components/shared/Alert";
export default {
    props: {
        message: { default: 'Mensagem' }
    },
    computed: {
        tooltipId() {
            return this._uid+"tooltip-message"
        }
    },
    methods: {
        click() {
            Alert.Confirm(this.$refs.content.innerHTML, 'Informação!')
        }
    },
}
</script>

<style scoped>
    #info-icon:hover {
        color: #2c3e50;
    }

    #info-icon-content {
        display: flex;
        justify-content: flex-end;
        align-content: space-around;
        margin-bottom: 10px;

    }
</style>
