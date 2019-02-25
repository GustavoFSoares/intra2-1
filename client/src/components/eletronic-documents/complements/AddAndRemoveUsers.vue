<template>
    <div @keyup.enter="findUserByName()" class="card">
        
        <div class="card-header">
            <span>{{ title.toUpperCase() }}:</span>
        </div>
        <row class="card-body">
            <div class='row'>
                <rows label='' class='col-md-8'>
                    <input type="search" class="form-control" v-model="nameFinded"  placeholder="Nome Parcial:"/>    
                </rows>
                <rows label=''>
                    <button @click="findUserByName()" class="btn btn-outline-primary" :disabled="!canFind">
                        Pesquisar
                        <icon v-if="finding" icon="spinner" pulse/>
                    </button>
                </rows>
            </div>
            <div class="container">
                <row label='Selecione um usário' v-if="users.length">
                    <v-select label="name" :options="(users)" v-model="userSelected" @input="addUser()"/>
                </row>
                
                <div :id="componentKey+'table'" class="list-group">
                    <draggable v-model="usersSelected" @update="update">
                        <transition-group id="users-selected">

                            <div v-for="(signature, index) in usersSelected" :key="index" class="card">
                                <router-link to="" class="text-left list-group-item list-group-item-action" data-toggle="collapse" :data-target="`#id${signature.user.id.substr(0, 3)}${index}${componentKey}`" aria-expanded="true" :aria-controls="`id${signature.user.id.substr(0, 3)}${index}${componentKey}`">
                                    <span class="float-left"><b>{{ index+1 }}º</b> - {{ signature.user.name }}</span>
                                    <router-link class="float-right" to="" @click.native="removeUser(signature.user, index)">
                                        <icon class="text-danger" icon="minus-circle"/>
                                    </router-link>
                                </router-link>

                                <div :id="`id${signature.user.id.substr(0, 3)}${index}${componentKey}`" class="collapse" :data-parent="'#'+componentKey+'table'">
                                    <div class="card">
                                        <div class="card-body">
                                            <span class="float-left">
                                                <div class="group">
                                                    <span><b>Setor: </b>{{ signature.user.group.name }}</span>
                                                </div>
                                                <div class="occupation">
                                                    <span><b>Cargo: </b>{{ signature.user.occupation }}</span>
                                                </div>
                                                <div class="email">
                                                    <span class="float-left" v-if="signature.user.email"><b>Email: </b> {{ signature.user.email }}</span>
                                                    <span class="float-left" v-else><b>Sem email cadastrado</b></span>                                
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </transition-group>
                    </draggable>
                </div>

            </div>
        </row>
    </div>
</template>

<script>
import draggable  from 'vuedraggable'
import AddAndRemoveUsers from "@/components/shared/AddAndRemove/AddAndRemoveUsers";
import EletronicDocumentSignature from "@/entity/EletronicDocuments/Signature";
export default {
    extends: AddAndRemoveUsers,
    methods: {
        addUser() {
            if( this.userSelected.id == this.$session.get('user').id ) {
                this.$alert.danger("Não é permitido adicionar o <b>Criador Documento</b>!")
                return ;
            }

            if(this.userSelected) {
                if(!this.checkIfExistOnList(this.userSelected)) {
                    
                    this.usersSelected.push(new EletronicDocumentSignature({
                        user: this.userSelected, 
                        order: this.usersSelected.length, 
                    }) )
                    this.userSelected = ''
                    this.users = []
                } else {
                    this.$alert.warning(`Usuário já adicionado!`)
                }
            }
        },
        checkIfExistOnList(userSelected) {
            return this.usersSelected.find(signature => { 
                return signature.user.id == userSelected.id
            })
        },
        update(evt) {
            let i
            i = evt.newIndex > evt.oldIndex ?
                { init: evt.oldIndex, end: evt.newIndex } : { init: evt.newIndex, end: evt.oldIndex }
            
            for (let index = i.init; index <= i.end; index++) {
                this.usersSelected[index].order = index+1
            }
            
        }
    },
    components: {
        draggable
    }
}
</script>