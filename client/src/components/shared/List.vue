<template>
    <div class="form">

        <div class="form-group form-row col">
            <input type="search" class="filter form-control" @input="filter = $event.target.value" placeholder="Nome:"/>
        </div>

        <ul class="form-group lista-fotos">
            <li class="lista-fotos-item" v-for="(foto, index) in searchList" :key="index">
                <a :href=foto.url v-if="foto.external">
                    <panel :titulo="foto.title">
                        <img class="img-thumbnail" :src="foto.icon" :alt="foto.title"/>
                    </panel>
                </a>
                <router-link :to=foto.url v-else>
                    <panel :titulo="foto.title">
                        <img class="img-thumbnail" :src="foto.icon" :alt="foto.title"/>
                    </panel>
                </router-link>

            </li>
        </ul>
        <h1 v-if="contacts.links">Tem Link</h1>
    </div>
</template>

<script>
import Panel from '@/components/shared/Panel.vue'
import links from '@/rows.js'
import { getLinks } from '@/services/links'
export default {

    data() {
        return {
            contacts: [ ],
            fotos: [ ],
            filter: '',
        }
    },
    components: {
        'panel': Panel,
    },
    created() {
        this.getFigures()
    },
    updated() { },
    methods: {
        getFigures(){
            this.fotos = links
        }
    },
     computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                return this.fotos.filter(fotos => exp.test(fotos.title))
            } else {
                return this.fotos
            }
        }
    },

}
</script>

<style scoped>
    .filter {
        display: block;
        width: 100%
    }

    .lista-fotos {
        list-style: none;
    }

    .lista-fotos .lista-fotos-item {
        display: inline-block;
    }

    img {
        width: 120px;
        height: 60px;
        margin: 4px;
        padding: 5px 5px 5px 5px;
        border: 1px solid;
        border-color: azure;
    }

</style>


