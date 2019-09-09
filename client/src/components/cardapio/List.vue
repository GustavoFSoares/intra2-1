<template>
    <div class="container-fluid">
        <h1>Cardápios</h1>

        <row :text_left="false">
            <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'cardapio/add'}" tag="button">
                Cadastrar Cardápio
            </router-link>
        </row>

        <big-table field_length="180" class="table-hover">
            <thead>
                <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Turno</th>
                    <th scope="col">Refeição</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(cardapio, index) in cardapios" :key="cardapio.id" class="row-list">
                    <td>{{ formatDate(cardapio.data) }}</td>
                    <td>{{ cardapio.refeicao }}</td>
                    <td>{{ cardapio.cardapio }}</td>
                    <td>
                        <a href="" @click.stop.prevent="$router.push(`cardapio/edit/${cardapio.id}`)">
                            <icon v-tooltip.top="'Editar'" icon="edit" />
                        </a>
                    </td>
                </tr>
                <!-- CASO NÃO ENCONTRE REGISTROS NO BANCO -->
                <tr class="row-list" v-if="cardapios.length == 0 && loaded">
                    <td class="bold text-disabled" colspan="50"> Nenhum registro encontrado </td>
                </tr>
            </tbody>
        </big-table>

    </div>
</template>

<script>
import Alert from "@/components/shared/Alert";
import Modal from "@/components/shared/Modal";
import BigTable from "@/components/shared/BigTable";
import model, { getter } from "@/model/cardapio-model";

export default {
    data: () => ({
        cardapios: [],
        loaded: false,
        cardapioSelecionado: false,
        user: $session.get('user'),
    }),
    methods: {
        formatDate(data) {
            let date = new Date(data.date).toLocaleDateString("pt-BR")
            return date
        }
    },
    mounted() {
        getter.getCardapios().then(res => {
            this.loaded = true
            this.cardapios = res
        })
        this.formatDate()
    },
    components: {
        'big-table': BigTable,
        'modal': Modal,
    }
}
</script>

<style lang="scss" scoped>
    .row-list:hover {
        cursor: pointer;
    }

    .status-buttons, .state-buttons {
        button {
            margin-left: 10px;
        }

        display: flex;
        justify-content: center;
    }
</style>