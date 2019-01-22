<template>
    <div class="list-center mb-3 mt-3">
        <div v-for="s in status" :key="s.id" class="list bold">
            <span class="text" v-bind:class="{ 'text-disabled' : actualStatusId != s.id }"> 
                {{ s.name }}
            </span> <span class="bar text-disabled">/</span>
        </div>
    </div>
</template>

<script>
import { getter } from "@/model/eletronic-documents-model";
export default {
    data() {
        return {
            status: '',
        }
    },
    props: {
        actualStatusId: { default: '' }
    },
    mounted() {
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
