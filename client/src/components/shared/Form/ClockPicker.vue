<template>
    <clock input-class="form-control text-center" :value="value" ref="clock" placeholder="--:--" id="clock-picker-1" done-text="Confirmar" cancel-text="Cancelar" @beforeClose="time = $refs.clock.getValue()" @close="send()"/>
</template>

<script>
import VueClockPicker from '@pencilpix/vue2-clock-picker';
import '@pencilpix/vue2-clock-picker/dist/vue2-clock-picker.min.css';

export default {
    props: {
        value: ''
    },
    data() {
        return {
            time: ''
        }
    },
    methods: {
        send() {
            this.$emit('close', this.time)
        }
    },
    components: {
        'clock': VueClockPicker
    }
}
</script>

<style scoped>

</style>
