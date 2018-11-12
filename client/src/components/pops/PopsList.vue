<template>
    <div>
        POPS
    </div>
</template>

<script>
import { getter } from "@/model/pops-model";
export default {
    data() {
        return {
            pops: ''
        }
    },
    mounted() {
        getter.getPops().then(res => { this.pops = res })
    },
}
</script>

<style scoped>

</style>