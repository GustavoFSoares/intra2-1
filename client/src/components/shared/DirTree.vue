<template>
    <div class="container">
        <!-- <div v-for="(file, index) in folder" :key="index">
            <div v-if="file.dir">
                <h2 @click="selected = file.name" :class="{'text-danger': folder[index][selected]}">{{file.name}}</h2>
                <br/>
                <uiv-collapse :class="{'show':folder[index][selected]}" v-model="folder[index][selected]">
                    <dir-tree :folder="file[file.name]"/>
                </uiv-collapse>
            </div>
            <div v-else>
                {{file.name}}
            </div>

        </div> -->
        <div :id="`${componentKey}acordeon`" class="list-group">
            <div v-for="(file, index) in folder" :key="index">
                <div v-if="file.dir">
                    {{file.name}}
                </div>
                <div>
                    <div v-if="file.dir">
                        <dir-tree :folder="file[file.name]" :componentKey="`${componentKey}${index}`" v-if="file.dir"/>
                    </div>
                    <div>
                        <p>{{file.name}} <span class="text-danger">(FILE)</span></p>
                    </div>
                </div>
                <!-- <div id="index">
                    <router-link to="" class="list-group-item list-group-item-action" data-toggle="collapse" :data-target="`#id-${componentKey}-${index}-${file.name}`" aria-expanded="true" :aria-controls="`id-${componentKey}-${index}-${file.name}`" v-if="file.dir">
                        {{ file.name }}
                    </router-link>
                </div>

                <div :id="`id-${componentKey}-${index}-${file.name}`" class="collapse" v-bind:class="{'show': file.dir != true }" aria-labelledby="index" :data-parent="`#${componentKey}acordeon`">
                    <div>
                        
                        <div>
                            <dir-tree :folder="file[file.name]" :componentKey="`${componentKey}${index}`" v-if="file.dir"/>
                            <div v-else>
                                {{file.name}}
                            </div>
                        </div>
                    </div>
                </div> -->
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
        componentKey: { default: '0' }
    },
    computed: { },
    mounted() {
        
    },
}    
</script>

<style scoped>

</style>