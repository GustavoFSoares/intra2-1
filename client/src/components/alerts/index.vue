<template>
    <div>
        <h1>{{ title }}</h1>

        <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'alertas/add'}" tag="button">
            Criar Alerta
        </router-link>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Título</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Prazo Inicio</th>
                    <th scope="col">Prazo Final</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(alert, index) in alerts" :key="alert.id">
                    <th scope="row">{{ alert.id }}</th>
                    <td>{{ alert.title }}</td>
                    <td>{{ alert.description }}</td>
                    <td :class='`text-${alert.type}`'>{{ alert.type.toUpperCase() }}</td>
                    <td>{{ alert.beginTime.date | humanizeDate }}</td>
                    <td>{{ alert.endTime.date | humanizeDate }}</td>
                    <td>
                        <router-link :to='`/usuario/alertas/edit/${alert.id}`'>
                            <icon icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(alert.id, index)" to="">
                            <icon icon="trash-alt" class="text-danger"/>
                        </router-link>
                    </td>
                </tr>
                <tr v-if="!alerts">
                    <td colspan="8"> Nenhum registro encontrado </td>
                </tr>
            </tbody>
        </table>
    </div>

</template>

<script>
import Alert from "@/entity/alert";
import model from "@/model/alert";
import moment from "moment";

export default {
    data() {
        return {
            title: "Alertas",
            alerts: [ new Alert() ],
            moment: moment,
        }
    },
    methods: {
        loadAlerts() {
            model.getAlerts().then(res => this.alerts = res)
        },
        remove(id, index) {
            confirm("Tem certeza que deseja excluir?") ?
                model.remove(id).then( () => this.$router.go() ):''
        }
    },
    mounted() {
        this.loadAlerts()
    },
}
</script>

<style lang="scss" scoped>
    table {
        margin-top: 10px;
    }
</style>
