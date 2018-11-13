<template>
    <div class="container" :id="`${componentKey}table`">
        <div v-for="(file, index) in folder" :key="`${componentKey}-${index}`">
                <router-link to="" :id="`#label-${index}-${componentKey}`" class="list-group-item list-group-item-action text-left" data-toggle="collapse" :data-target="`#id-${componentKey}-${index}`" aria-expanded="true" :aria-controls="`id-${componentKey}-${index}`" v-if="file.dir">
                    {{ file.name }}
                </router-link>

                <div :id="`id-${componentKey}-${index}`" class="collapse" v-bind:class="{'show': !file.dir}" :aria-labelledby="`#label-${index}-${componentKey}`" :data-parent="`#${componentKey}table`">
                    <div v-if="file.dir">
                        <dir-tree :folder="file[file.name]" :componentKey="`${componentKey}${index}`"/>
                    </div>
                    <div v-else class="text-right">
                        <p class="text-primary btn-link">{{file.name}}</p>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'dir-tree',
    data() {
        return {
            selected: '',
        }
    },
    props: {
        folder: '',
        componentKey: { default: '1' }
    },
    computed: { },
    mounted() {
        
    },
}    
</script>

<style scoped>

</style>