<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>
        <!-- <div class="form-group form-row col">
            <input type="search" class="filter form-control" :disabled="!pops" v-model="filter" placeholder="Pesquisa:"/>
        </div> -->
        
        <dir-tree :folder="pops" :filter="filter" class="mt-4"/>
    </div>
</template>

<script>
import { getter } from "@/model/pops-model";
import DirTreeVue from '@/components/shared/DirTree.vue';
export default {
    data() {
        return {
            title: "POP's",
            pops: '',
            filter: ''
        }
    },
    mounted() {
        getter.getPops().then(res => { this.pops = res })
    },
    components: {
        'dir-tree': DirTreeVue
    }
}
</script>