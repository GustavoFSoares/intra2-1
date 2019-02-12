<template>
    <div class="list-center mb-3 mt-3">
        <div v-for="s in status" :key="s.id" class="list bold">
            <span v-if="id == s.id" class="text" @mouseover="showThisGuy = true" @mouseout="showThisGuy = false"> 
                {{ s.name }}
            </span> 
            <span v-else class="text text-disabled"> 
                {{ s.name }}
            </span> 
            <span class="bar text-disabled">/</span>
        </div>
        <div> 
            <span v-if="showThisGuy && user.name" class="text-disabled">
                Próximo à Assinar: {{ user.name }}
            </span>
        </div>
    </div>
</template>

<script>
import { getter } from "@/model/eletronic-documents-model";
import User from "@/entity/User";
export default {
    data() {
        return {
            status: '',
            id: '',
            showThisGuy: false,
            user: new User(),
        }
    },
    props: {
        actualStatusId: { default: '' },
        documentId: '',
    },
    watch: {
        actualStatusId() {
            return this.getId()
        },
        documentId() {
            this.getNextUser()
        }
    },
    methods: {
        getId() {
            if(typeof this.actualStatusId == 'object') {
                this.id = this.actualStatusId.id
            } else {
                this.id = this.actualStatusId
            }
            return this.id
        },
        getNextUser() {
            if(this.documentId) {
                getter.getNextUserToSign(this.documentId).then(res => {
                    this.user = new User(res)
                })
            }
        }
    },
    mounted() {
        this.getId()
        getter.getStatus().then(res => {
            this.status = res
        })
        this.getNextUser()
    }, 
}
</script>

<style scoped>
    .list-center {
        text-align: center;
    }

    .list {
        display: inline;
    }

    .list .bar {
        margin-left: 4px;
        margin-right: 4px;
        pointer-events: none;
    }

    .list:last-of-type .bar {
        display: none;
    }

    .text:not(.text-disabled) {
        color: var(--red)
    }
</style>
