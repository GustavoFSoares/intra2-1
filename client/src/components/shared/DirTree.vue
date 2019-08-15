<template>
    <div class="container" :id="`${componentKey}table`">
        <div v-for="(file, index) in folderList" :key="`${componentKey}-${index}`">
            <router-link to="" :id="`#label-${index}-${componentKey}`" class="list-group-item list-group-item-action text-left" data-toggle="collapse" :data-target="`#id-${componentKey}-${index}`" aria-expanded="true" :aria-controls="`id-${componentKey}-${index}`" v-if="file.dir">
                <span v-bind:class="{'title': componentKey == 1}">{{ file.name }}</span>
            </router-link>

            <div :id="`id-${componentKey}-${index}`" class="collapse" v-bind:class="{'show': !file.dir}" :aria-labelledby="`#label-${index}-${componentKey}`" :data-parent="`#${componentKey}table`">
                <div v-if="file.dir">
                    <dir-tree :folder="file[file.name]" :componentKey="`${componentKey}${index}`" :filter="filter" />
                </div>
                <div v-else class="text-right">
                    <a class="file" target="_blank" v-bind:class="{'opened':file.opened}" @click="open(file)" :href="`${location.protocol}//${location.hostname}:3001/file/?filePath=${file.path}`">
                        {{index+1}} - {{file.name}}
                    </a>
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
            location: window.location
        }
    },
    props: {
        folder: '',
        componentKey: { default: 'a' },
        filter: '',
    },
    methods: {
        open(file) {
            file.opened = true
            file.name = file.name+" "
        }
    },
    computed: { 
        folderList() {
            if(this.$props.filter && this.$props.componentKey != 1) {
                var countFile = 0
                let files = this.$props.folder
                
                let exp = new RegExp(this.$props.filter.trim(), 'i')
                
                let folderList = this.$props.folder.filter(file => {

                    if( exp.test(file.name)) {
                        if(file.path) {
                            let a = 1     
                            countFile++
                        } else if(file.dir) {
                            let a = 1
                            countFile++
                        }
                        
                        return exp
                    }
                })
                
                if(files[0]['path']) {
                    
                    if(!countFile) {
                        //console.log('tem file');
                        return files

                    } else {
                        //console.log('nao file');
                        return folderList
                    }
                    
                } else {
                    if(folderList.length ) {
                                      
                        return folderList
                    } else {
                        //console.log('dir nao');
                        return this.$props.folder
                    }
                }
            } else {
                return this.$props.folder
            }
        }   
    },
}    
</script>

<style lang="scss" scoped>
    .file {
        color: #6c757d;
    }

    .opened {
        color: #609
    }

    .title {
        font-weight: bold;
    }
</style>