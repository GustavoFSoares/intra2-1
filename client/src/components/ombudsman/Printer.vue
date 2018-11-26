<template>
    <div>
        <router-link to="">
            <icon icon="print" size="3x"/>
        </router-link>
        <modal title="Impressão de Ouvidorias" ref="modal" @return="exportFile()">
            <div class='row pull-center'>
                <rows label='Origem de Ouvidoria' class="col-md-8">
                    <v-select :options="origin" label="name" v-model="doc.origin"/>
                </rows>

                <rows label="Quantidade de Páginas">
                    <div>
                        <router-link to="" id="icon" v-if="doc.page > 1" @click.native="doc.page--"> 
                            <icon  icon="minus"/>
                        </router-link>                        
                        
                        <span id="level">{{ doc.page }}</span>
                        
                        <router-link to="" id="icon" v-if="doc.page < 20" @click.native="doc.page++">
                            <icon icon="plus"/> 
                        </router-link>
                    </div>
                </rows>
            </div>
        </modal>
    </div>
</template>

<script>
import { getter } from "@/model/ombudsman-model";
import { VueSelect, FormRws } from "@/components/shared/Form";
export default {
    data() {
        return {
            origin: [],
            doc: {
                page: '1',
                origin: '',
            }
        }
    },
    methods: {
        openModal() {
            this.$refs.modal.show()
        },
        exportFile() {
            window.open(`${window.location.protocol}//${window.location.hostname}:3001/ombudsman/doc/?page=${this.doc.page}&type=${this.doc.origin.id}`, '_target')
        }
    },
    mounted() {
        getter.getOrigins().then(res => { this.origin = res })
    },
    components: {
        'modal': require("@/components/shared/Modal.vue").default,
        'v-select': VueSelect,
        'rows': FormRws,
    }
}
</script>
