<template>
    <div>
        <h1>{{welcome}}</h1>
        <h1>{{message}}</h1>
        <h1>{{count}}</h1>
        <button @click="pressed">Click me</button>
    </div>
</template>

<script>
import { modal } from "@/store";
export default {
    data() {
        return {
            welcome: "OLA MEU CHAPA"
        }
    },
    computed: {
        message() {
            return modal.getters.message
        },
        count() {
            return modal.getters.counter
        }
    },
    methods: {
        pressed(){
            modal.dispatch('increment', 20)
        }
    },
}
</script>


<style scoped>

</style>