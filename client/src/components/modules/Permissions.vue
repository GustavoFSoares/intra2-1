<template>
    <div class="container">
        <h1>{{ title }}</h1>

        <div class="">
            <v-select v-model="group" data-vv-as="Grupo" v-validate data-vv-rules="required" label="name" :options="groups" name="groups" class="space" @input="loadModules(listId)"/>
            <table v-if="group" class="table table-striped table-sm space">
                <thead>
                    <tr>
                        <th><span class="">Módulo</span></th>
                        <th><span class="button">Status</span></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(module, index) of modules" :key="index+listId">
                        <td>
                            <span class="">{{ module.name }}</span>
                        </td>
                        <td>
                            <checkbox class="button" :checked="module.active" @changed="change(module)"/>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button @click="submit()" class="btn btn-outline-primary">Salvar</button>

    </div>   
</template>

<script>
import model, { getter } from "@/model/modules-model";
import { Checkbox } from "@/components/shared/Form";
import { VueSelect } from "@/components/shared/Form";

export default {
    data() {
        return {
            title: "Gerenciador de Acesso",
            modules: [],
            toChange: [],
            group: '',
            groups: [],
            listId: ''
        }
    },
    methods: {
        loadModules(listId) {
            this.toChange = []
            let id = listId
            this.group.groupId ?
                id = this.group.groupId : id = this.group

            getter.getModules().then(res => {
                let modules = []
                res.forEach(module => {
                    modules.push({ id: module.id, name: module.name, groups: module.groups, active: this.isActive(module.groups, id) })
                })
                this.modules = modules
                this.listId = id
            })
        },
        isActive(groups, groupID){
            return groups[groupID] ? true : false
        },
        change(module) {
            let exist = false, id = 'a';
            this.toChange.forEach(el => {
                if(module.id == el.module){
                    exist = true
                    id = this.toChange.indexOf(el)
                }
            })

            if(exist){
                this.toChange.splice(id, 1)
            } else {
                this.toChange.push({ module: module.id, group: this.group.id, name: module.name, active: !module.active })
            }
        },
        submit() {
            model.doPermissionForGroup(this.toChange).then(res => { this.$router.go('-1') })
        },
    },
    mounted() {
        getter.getGroups().then(res => { this.groups = res })
    },
    components: {
        'checkbox': Checkbox,
        'v-select': VueSelect,
    }
}
</script>

<style scoped>
    .space {
        margin-top: 3%;
    }

    .button {
        margin-right: 13%;
    }

    span {
        font-size: 20px;
    }

</style>

