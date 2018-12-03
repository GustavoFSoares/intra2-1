<template>
    <div>
        <div class='row'>
            <rows label='<b>Imprimir Ouvidoria</b>'>
                <div>
                    <router-link to="" @click.native="open('newFolder')">
                        <icon icon="print" size="3x"/>
                    </router-link>
                </div>
            </rows>
            <rows label='<b>Re-imprimir</b>'>
                <div>
                    <router-link to="" @click.native="open('olderOmbudsman')">
                        <icon icon="print" class="text-danger" size="3x"/>
                    </router-link>
                </div>
            </rows>
        </div>
        <modal title="Impressão de Ouvidorias" ref="newFolder" @return="exportFile()">
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
        <modal title="Ouvidorias Perdidas" ref="olderOmbudsman" @return="alert('imprimir')">
            <div>
                123
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
        open(type) {
            if(type == 'newFolder') {
                this.$refs.newFolder.show()
            } else {
                this.$refs.olderOmbudsman.show()
            }
        },
        doPrint() {
        },
        exportFile() {
            window.open(`${window.location.protocol}//${window.location.hostname}:3001/ombudsman/doc/?page=${this.doc.page}&origin=${this.doc.origin.id}`, '_target')
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
