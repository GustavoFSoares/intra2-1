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
            <span v-if="showThisGuy" class="text-disabled">
                * Gustavo Soares 
            </span>
        </div>
    </div>
</template>

<script>
import { getter } from "@/model/eletronic-documents-model";
export default {
    data() {
        return {
            status: '',
            id: '',
            showThisGuy: false,
        }
    },
    props: {
        actualStatusId: { default: '' }
    },
    watch: {
        actualStatusId() {
            return this.getId()
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
        }
    },
    mounted() {
        this.getId()
        getter.getStatus().then(res => {
            this.status = res
        })
    }
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
