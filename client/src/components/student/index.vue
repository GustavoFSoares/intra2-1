<template>
    <div class="container-fluid">

        <div class="mb-4">
            <router-link class=" button btn btn-outline-secondary btn-lg" :to="{name: 'universitarios/add'}" tag="button">
                Cadastrar Universitários
            </router-link>
        </div>

        <div class="mb-3">
            <div class="btn-group" role="group" aria-label="Basic example">
                <router-link to="" class="btn btn-primary" v-for="(type, index) in types" :key="index" @click.native="search.type = type">{{ type.name }}</router-link>
                <router-link to="" class="btn btn-primary" @click.native="search.type = {id: '', name: ''}">Todos</router-link>
            </div>
        </div>
        
        <div class="form-group form-row col">
            <input type="search" class="filter form-control" :disabled="!students" @input="search.filter = $event.target.value" placeholder="Nome:"/>
        </div>

        <h2>{{ typeExibited }}</h2>

        <table v-if="students" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Setor</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Início</th>
                    <th scope="col">Termino</th>
                    <th scope="col">Turno</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(student) of searchList" :key="student.id" v-bind:class="{'table-danger': student.c_removed == '1'}">
                    <td>{{ student.id }}</td>
                    <td>{{ student.name }}</td>
                    <td>{{ student.complement.type.name }}</td>
                    <td>{{ student.occupation }}</td>
                    <td>{{ student.group.name }}</td>
                    <td>{{ student.group.enterprise }}</td>
                    <td>{{ moment(student.complement.hire.date).format('DD/MM/YYYY') }}</td>
                    <td>{{ moment(student.complement.fire.date).format('DD/MM/YYYY') }}</td>
                    <td>{{ student.complement.turn }}</td>
                    <td>
                        <icon class="text-success" icon="check-circle" v-if="!student.c_removed"/>
                        <icon class="text-danger" icon="times-circle" v-else/>
                    </td>
                    <td>
                        <router-link :to='`universitarios/edit/${student.id}`'>
                            <icon icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(student.id)" to="">
                            <icon class="text-danger" icon="trash-alt"/>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import model, { getter } from '@/model/student-model'
import moment from 'moment'

export default {
    data() {
        return {
            typeExibited: '',
            students: [],
            moment: moment,
            search: {
                filter: '',
                type: ''
            },
            types: '',
        }
    },
    methods: {
        mounteStudents() {
            getter.getStudents().then(res => {this.students = res })
            getter.getStudentTypes().then(res => {this.types = res })
        },
        remove(id){
           if (confirm("Tem certeza que deseja excluir?")) {
                model.doDelete(id).then(res => this.$router.go())
            }
        },
    },
    mounted() {
        this.mounteStudents()
    },
    computed: {
        searchList() {

            if(this.search.type) {
                this.typeExibited = this.search.type.name
                let type = new RegExp(this.search.type.id.trim(), 'i')
                
                return this.students.filter(students => {
                    if( type.test(students.complement.type.id )) {
                        return type
                    }
                })

            }
            
            if(this.search.filter) {
                let exp = new RegExp(this.search.filter.trim(), 'i')
                
                return this.students.filter(students => {
                    
                    if( exp.test(students.id)) {
                        return exp
                    } else if( exp.test(students.name)) {
                        return exp
                    } else if( exp.test(students.group.name)) {
                        return exp
                    } else if( exp.test(students.occupation)) {
                        return exp
                    } else if( exp.test(students.group.enterprise)) {
                        return exp
                    } else if( exp.test(students.complement.turn)) {
                        return exp
                    } else if( exp.test(moment(students.complement.hire.date).format('DD/MM/YYYY'))) {
                        return exp
                    } else if( exp.test(moment(students.complement.fire.date).format('DD/MM/YYYY'))) {
                        return exp
                    }
                })
            } else {
                return this.students
            }
        }
    },
}
</script>

<style scoped>

</style>
