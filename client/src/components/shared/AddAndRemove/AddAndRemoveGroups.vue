<template>
    <div>
        <label>{{ title }}:</label>
        <row>
            <div class="container">
                <row label='Selecione um grupo'>
                    <v-select label="name" :options="groups" v-model="groupSelected" @input="addGroup()" ref="select"/>
                </row>
                
                <div :id="componentKey+'table'" class="list-group">
                    <div v-for="(group, index) in groupsSelected" :key="index" class="card">

                        <router-link to="" class="text-left list-group-item list-group-item-action" data-toggle="collapse" :data-target="`#id${group.id}${componentKey}`" aria-expanded="true" :aria-controls="`id${group.id}${componentKey}`">
                            <span class="float-left">{{ group.name }}</span>
                            <router-link class="float-right" to="" @click.native="removeGroup(group, index)">
                                <icon class="text-danger" icon="minus-circle"/>
                            </router-link>
                        </router-link>

                        <div :id="`id${group.id}${componentKey}`" class="collapse" :data-parent="'#'+componentKey+'table'">
                            <div class="card">
                                <div class="card-body">
                                    <span class="float-left">
                                        <div class="id">
                                            <span><b>ID: </b>{{ group.id }}</span>
                                        </div>
                                        <div class="enterprise">
                                            <span><b>Empresa: </b>{{ group.enterprise }}</span>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </row>
    </div>
</template>

<script>
import { getter } from "@/model/group-model";
export default {
    data: () => ({
        groups: [],
        groupSelected: '',
        groupsSelected: [],
        nameFinded: '',
        finding: false,
        componentKey: '',
    }),
    props: { 
        title: { default: 'Adicionar Grupos' }
    },
    watch: {
        groupsSelected() {
            this.$emit('input', this.groupsSelected)
       }
    },
    methods: {
        addGroup() {
            if(this.groupSelected) {
                if(!this.checkIfExistOnList(this.groupSelected)) {
                    this.groupsSelected.push(this.groupSelected)
                    setTimeout(() => {
                        this.$refs.select.clearSelection()
                        this.groupSelected = ''
                    }, 1000);
                } else {
                    this.$alert.warning(`Gropo já adicionado!`)
                }
            }
        },
        removeGroup(group, index) {
            this.groupsSelected.splice(index, 1)
        },
        checkIfExistOnList(groupSelected) {
            return this.groupsSelected.find(group => { 
                return group.id == groupSelected.id
            })
        }
    },
    mounted() {
        this.componentKey = "c_key"+this._uid,
        getter.getGroups().then(res => { this.groups = res })
        
    }
}
</script>