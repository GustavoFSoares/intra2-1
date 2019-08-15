<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <dir-tree :folder="archives" :filter="filter" class="mt-4"/>
    </div>
</template>

<script>
import { getter } from "@/model/archives-model";
import DirTreeVue from '@/components/shared/DirTree.vue';
export default {
    data() {
        return {
            title: "Arquivos",
            archives: '',
            filter: ''
        }
    },
    mounted() {
        getter.getArchives().then(res => { this.archives = res })
    },
    components: {
        'dir-tree': DirTreeVue
    }
}
</script>