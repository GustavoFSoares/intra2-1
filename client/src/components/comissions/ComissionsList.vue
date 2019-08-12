<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>
        
        <dir-tree :folder="comissions" :filter="filter" class="mt-4"/>
    </div>
</template>

<script>
import { getter } from "@/model/comission-model";
import DirTreeVue from '@/components/shared/DirTree.vue';
export default {
    data() {
        return {
            title: "Comissões",
            comissions: '',
            filter: ''
        }
    },
    mounted() {
        getter.getComissions().then(res => { this.comissions = res })
    },
    components: {
        'dir-tree': DirTreeVue
    }
}
</script>