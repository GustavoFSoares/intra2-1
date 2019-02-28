<template>
    <div id="actual-status-component" ref="actualStatusComponent" class="mb-3 mt-3">
        
        <ul class="list bold">
                    
            <li v-for="s in status" :key="s.id" @mouseover="showThisGuy = true" @mouseout="showThisGuy = false"> 
                <span class="name text text-disabled" v-bind:class="{ 'text-danger': id == s.id }" >
                    {{ s.name }}
                </span>
            </li>
        
        </ul>
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

        if ( this.$refs.actualStatusComponent.clientWidth < 800 ) {
            this.$refs.actualStatusComponent.setAttribute('size', 'small')
        }
    },
}
</script>

<style lang="scss" scoped>
    #actual-status-component[size=small] li:nth-child(2) {
        display: none;
    }

    ul {
        padding: 0;
    }

    .list {
        list-style: none;
        display: flex;
        justify-content: center;

        li {
            &:first-child::before {
                display: none;
            }

            &::before {
                content: '/';
            }
        }

        .name {
            padding: 5px;
        }
    }
</style>
