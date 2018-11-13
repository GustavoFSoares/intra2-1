<template>
    <div class="container">
        <dir-tree :folder="pops"/>
    </div>
</template>

<script>
import { getter } from "@/model/pops-model";
import DirTreeVue from '@/components/shared/DirTree.vue';
export default {
    data() {
        return {
            pops: ''
        }
    },
    mounted() {
        getter.getPops().then(res => { this.pops = res; console.log(res); })
    },
    components: {
        'dir-tree': DirTreeVue
    }
}
</script>

<style scoped>

</style>