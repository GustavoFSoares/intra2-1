<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <div class="form-group form-row col">
            <input type="search" class="filter form-control" @input="filter = $event.target.value" placeholder="Nome:"/>
        </div>
        
        <hr>
        <div class="container">

            <div class="list-group">
                <div class="row">
                    <div class="col-md-6 line" v-for="(covenant) in searchList" :key="covenant.id" v-if="!covenant.c_removed">
                        <a :href="covenant.link" target="_blank" class="list-group-item list-group-item-action">{{ covenant.title }}</a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>
import { getter } from "@/model/covenants-model";
export default {
    data() {
        return {
            title: "Lista de Convenios",
            covenants: "",
            filter: "",
        }
    },
    mounted() {
        getter.getCovenants().then( res => { this.covenants = res })
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                let list = ''
                return this.covenants.filter(covenants => {
                    if( exp.test(covenants.title)) {
                        return exp
                    }
                })
            } else {
                return this.covenants
            }
        }
    },
}
</script>

<style scoped>
    .line {
        margin-top: 10px;
    }
</style>