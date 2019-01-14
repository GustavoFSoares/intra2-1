<template>
    <div @keyup.enter="findUserByName()">
        
        <label>{{ title }}:</label>
        <row>
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
                    <div v-for="(signature, index) in usersSelected" :key="index" class="card">

                        <router-link to="" class="text-left list-group-item list-group-item-action" data-toggle="collapse" :data-target="`#id${signature.user.id.substr(0, 3)}${index}${componentKey}`" aria-expanded="true" :aria-controls="`id${signature.user.id.substr(0, 3)}${index}${componentKey}`">
                            <span class="float-left">{{ signature.user.name }}</span>
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
                </div>

            </div>
        </row>
    </div>
</template>

<script>
import AddAndRemoveUsers from "@/components/shared/AddAndRemove/AddAndRemoveUsers";
import EletronicDocumentSignature from "@/entity/EletronicDocuments/Signature";
export default {
    extends: AddAndRemoveUsers,
    methods: {
        addUser() {
            if(this.userSelected) {
                if(!this.checkIfExistOnList(this.userSelected)) {
                    this.usersSelected.push(new EletronicDocumentSignature({ user: this.userSelected }) )
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
        }
    },
}
</script>