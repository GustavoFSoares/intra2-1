<template>
    <div>
        <row label='Fechamento do Ouvidor' v-if="(status == 'waiting-manager' || status == 'registered') && gotAdminPermission">
            <textarea v-model="text" ref="textarea" class="form-control" cols="30" rows="4" @input="uploadValue()"/>
        </row>
        <row v-else>
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Relato do Ouvidor:</h6>
                    <p class="card-text">
                        {{ value }}
                    </p>
                </div>
            </div>
        </row>
        <signature label="Você está logado como" :username="ombudsmanClosingName"/>
    </div>
</template>

<script>
import { FormRw, FormRws, Require, VueSelect } from "@/components/shared/Form";

export default {
    data() {
        return {
            text: "",
            ombudsman: this.$session.get('user')
        }
    },
    watch: {
        value(val) {
            if(val) {
                this.text = val
            }
        }
    },
    props: {
        value: { default: "" },
        status: { default: "" },
        ombudsmanClosingName: { default: "" },
        gotAdminPermission: { default: false },
    },
    methods: {
        uploadValue() {
            this.$emit('input', this.text)
        },
    },
    components: {
        'row': FormRw,
        'signature': require('@/components/shared/Signature.vue').default,
    }
}
</script>
