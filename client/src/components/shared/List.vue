<template>
    <div class="form">

        <div class="form-group form-row col">
            <input type="search" class="filter form-control" @input="filter = $event.target.value" placeholder="Nome:"/>
        </div>

        <ul class="form-group lista-links">
            <li class="lista-links-item" v-for="(link, index) in searchList" :key="index">
                <a :href="link.url" v-if="link.externalLink">
                    <panel :titulo="link.title">
                        <img class="img-thumbnail" :src="link.icon" :alt="link.title"/>
                    </panel>
                </a>
                <router-link :to="link.url" v-else>
                    <panel :titulo="link.title">
                        <img class="img-thumbnail" :src="link.icon" :alt="link.title"/>
                    </panel>
                </router-link>

            </li>
        </ul>
    </div>
</template>

<script>
import Panel from '@/components/shared/Panel.vue'
import { getLinks } from '@/services/links'
export default {

    data() {
        return {
            contacts: [ ],
            links: [ ],
            filter: '',
        }
    },
    components: {
        'panel': Panel,
    },
    updated() { },
    beforeCreate() {        
        getLinks().then(res => this.links = res );
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                return this.links.filter(links => exp.test(links.title))
            } else {
                return this.links
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

    .lista-links {
        list-style: none;
    }

    .lista-links .lista-links-item {
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


