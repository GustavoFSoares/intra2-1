<template>
    <div v-if="document">
        
        <actual-status :actualStatusId="document.status.id"/>
        <row>
            <h3>{{ document.subject }}</h3>
        </row>
        <row>
            <span>
                <b>Criador:</b> {{document.user.name}}
            </span>
        </row>
        
        <row label='Lista de Usuários'>
                <table class="table">
                    <thead class="text-center">
                        <th> Nome </th>
                        <th> A/C </th>
                        <th> Assinado </th>
                    </thead>
                    <tbody>
                        <tr v-for="signature in document.signatureList" :key="signature.id">
                            <td>{{ signature.user.name }}</td>
                            <td>
                                <span v-if="signature.bc" class="text-success bold"> SIM </span>
                            </td>
                            <td>
                                <div v-if="signature.signed" class="row bold">
                                    <icon icon="check" class="text-success col-md-2"/>
                                    <span class="text-success col-md"> ASSINADO </span>
                                </div>
                                <div v-else class="row bold">
                                    <icon icon="times" class="text-danger col-md-2"/>
                                    <span class="text-danger col-md"> AGUARDANDO </span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </row>
        <!-- <rows id="create-at" class="text-right">
                <span class="text-disabled bold">
                    {{ document.createdAt.date | humanizeDate }}
                </span>
            </rows> -->

    </div>
</template>

<script>
import ActualStatus from "./ActualStatus"
export default {
    data() {
        return {

        }
    },
    props: {
        document: false,
    },
    components: {
        'actual-status': ActualStatus,
    }
}
</script>
