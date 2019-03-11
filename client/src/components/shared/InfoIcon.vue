<template>
    <div>
        <div @click="show()" id="info-icon-content">
            <icon id="info-icon" icon="info-circle" class="text-disabled bold" v-tooltip.top="'Clique para Informações'"/>
            <div v-show="false" ref="content">
                <slot >
                    Corpo da Mensagem
                </slot>
            </div>
        </div>
    </div>
</template>

<script>
import Alert from "@/components/shared/Alert";
export default {
    props: {
        title: { default: 'Informação!' },
        size: '',
    },
    computed: {
        tooltipId() {
            return this._uid+"tooltip-message"
        }
    },
    methods: {
        show() {
            let size
            switch (this.size) {
                case '-1':
                    size = 'small'    
                    break;
                
                case '0':
                    size = ''    
                    break;
                
                case '1':
                    size = 'large'
                    break;
            
                default:
                    size = ''
                    break;
            }
            Alert.Confirm(this.$refs.content.innerHTML, this.title, size)
        }
    },
}
</script>

<style lang="scss" scoped>
    #info-icon:hover {
        color: #2c3e50;
    }

    #info-icon-content {
        display: flex;
        justify-content: flex-end;
        align-content: space-around;
        align-self: flex-start;
    }
</style>
