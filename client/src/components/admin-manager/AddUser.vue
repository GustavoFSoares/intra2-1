<template>
    <div>
        <modal :title="title" ref="modal" @return="sendUserSelected()">
            <v-select label="name" :options="(users)" v-model="userSelected"/>
        </modal>
    </div>
</template>

<script>
const UserModel = require("@/model/user-model").getter;
import { VueSelect } from "@/components/shared/Form";
import Modal from '@/components/shared/Modal.vue'
export default {
    data() {
        return {
            title: "Adicionar Usuário",
            users: [],
            userSelected: '',
        }
    },
    props: {
        group: '',
    },
    methods: {
        openModal(groupId) {
            this.loadValues()
            this.$refs.modal.show()
        },
        loadValues() {
            this.userSelected = ''
            UserModel.getUsersActivedByGroupId(this.group).then(res => this.users = res)
        },
        sendUserSelected() {
            this.$emit('close', this.userSelected)
        }
    },
    components: {
        'modal': Modal,
        'v-select': VueSelect,
    },
}
</script>
