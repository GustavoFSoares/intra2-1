<template>
    <div class="col-md-6 line">
        <div class="card">
            <span class="card-header">{{ user.name }}
                <router-link @click.native="added()" to="" v-if="icon == 'add'"><icon class="float-right" icon="plus"/></router-link>
                <router-link @click.native="removed()" to="" v-if="icon == 'remove'"><icon class="float-right" icon="minus"/></router-link>
            </span>
            <div class="card-body">
                <div class="row">
                    <span class="col text-left">Matricula: {{ user.code }}</span>
                    <span class="col text-right">Turno: {{ user.turn }}</span>
                </div>
                <div class="row">
                    <span class="col text-left">Cargo: {{ user.occupation }}</span>
                    <span class="col text-right">Setor: {{ user.group }}</span>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import User from "@/entity/User";

export default {
    props: {
        user: '',
        icon: { default: false },
    },
    methods: {
        added() {
            this.$emit('added')
        },
        removed() {
            this.$emit('removed')
        }
    }
}
</script>

