<template>
    <div class="container">
        <div class="file">
                
            <ul class="waiting-list" v-if="!only_exibition">
                <li class="waiting-file" v-for="(file) in files" :key="file.id">
                    <span class="text">
                        {{file.name}} - {{file.size | formatSize}}
                        
                        <span v-if="file.error">
                            <span class="text-danger"> <icon icon="times" size="lg"/> <b>{{file.error}}</b> </span>

                            <router-link to="" @click.native="submitFile(file)" v-if="!file.formatError">
                                <icon icon="sync-alt"/>
                            </router-link>
                        </span>
                        
                        <span v-else-if="file.success">
                            <icon class="text-success" icon="check" size="lg"/>
                        </span>

                    </span>
                </li>
                
                <div v-if="(files.length == 0 && filesPath.length == 0) && !filePath">
                    <span class="text-danger"> Sem documento </span>
                </div>
            </ul>

            <ul class="saved-list">
                <li class="saved-file" v-for="(fp, index) in filesPath" :key="index">
                    <router-link class="icon-remove" to="" @click.native="removeFile(fp, index)" v-if="!only_exibition">
                        <icon icon="times-circle"/>
                    </router-link>
                    <a class="text-default text" v-if="fp" :href="`${$globals.API_SERVER}/file/?filePath=${fp.path}&onScreen=1`" target="_blank">
                        <icon class="text-danger" icon="file-pdf" size="2x"/> {{ fp.name }}
                    </a>
                </li>
                <div v-if="noFile == true">
                    <span class="text-danger"> Sem documento </span>
                </div>
                <div v-if="loadingFile">
                    <icon icon="spinner" size="2x" spin/>
                    <div class="text-disabled bold">Procurando Documento...</div>
                </div>
            </ul>
                
        </div> 

        <row v-if="!only_exibition">
            <div>
                <upload-component id="upload-component" class="btn btn-outline-primary" 
                    v-bind:class="{'disabled': !this.id || sending }"
                    @input-filter="inputFilter"
                    :custom-action="submitFile"
                    :chunk-enabled="true"
                    :multiple="true"
                    ref="upload" 
                    accept="application/pdf" 
                    v-model="files"> 
                    <icon icon="file"/> Selecionar Documento
                </upload-component>
                
                <button class="btn btn-outline-success disable-pointer"
                    v-bind:class="{'disabled': !this.id}"
                    v-show="!$refs.upload || !$refs.upload.active" 
                    @click.prevent="$refs.upload.active = true" 
                    :disabled="sending"
                    type="button">
                    <icon icon="upload"/> Enviar
                </button>
                <button  class="btn btn-outline-danger disable-pointer"
                    v-bind:class="{'disabled': !this.id}"
                    v-show="$refs.upload && $refs.upload.active" 
                    @click.prevent="$refs.upload.active = false; sending = false" 
                    type="button">
                    <icon icon="hand-paper"/> Parar Envio 
                </button>
                <icon v-if="sending" class="text-primary" icon="spinner" size="lg" spin/>
            </div>       
            <div v-if="!id" id="id-message">
                <span class="text-danger"> Aguardando ID </span>
            </div>
        </row>

    </div>
</template>

<script>
import service from '@/services/file'
import Alert from "@/components/shared/Alert";

export default {
    data() {
        return {
            files: [],
            filesPath: [],
            filePath: '',
            sending: false,
            loadingFile: false,
            noFile: false,
        }
    },
    props: {
        id: { default: false },
        post_function: '',
        origin: '',
        only_exibition: { default: false },
    },
    methods: {
        async submitFile(file) {
            this.sending = true
            let formData = new FormData()
            formData.append('file', file.file);
            
            this.post_function(formData, this.fileName, this.id).then(res => {
                file.error = null
                this.sending = false
                file.path = res

                this.files.splice( this.indexOf(file), 1 )
                this.filesPath.push(file)
            }).catch(err => {
                this.$refs.upload.update(file, {error: 'Não Salvo!'+err})
                this.sending = false
            }) 
        },

        inputFilter(newFile, oldFile, prevent) {
            if (newFile && !oldFile) {
                if (!/\.(pdf)$/i.test(newFile.name)) {
                    newFile.error = "Formato não compatível"
                    newFile.formatError = true
                }
            }

            let URL = window.URL || window.webkitURL
            if (URL && URL.createObjectURL) {
                newFile.blob = URL.createObjectURL(newFile.file)
            }
        },
        showExemple(path) {
            let route = this.$router.resolve({ path: '/file/', query: { onScreen: true, filePath: path }});
            window.open(`${this.$globals.API_SERVER}/${route.href}`, '_blank')
        },
        findFile(id) {
            if(id) {
                this.loadingFile = true
                service.getFilesOfFolder(id, this.origin).then( res => {
                    this.filesPath = res
                    
                    if( res.length == 0 ) {
                        this.noFile = true
                        this.$emit('noFile', this.noFile)
                    }
                    
                    this.loadingFile = false    
                }).catch(err => {
                    this.loadingFile = false
                })
            }
        },
        indexOf(file) {
            let i
            this.files.forEach( (el, index) => {
                if( el.id == file.id ) {
                    i = index
                }
            });

            return i
        },
        removeFile(file, index) {
            Alert.YesNo(`Voce está removendo "${file.name}"`, 'Tem certeza que deseja continuar?').then(res => {
                if(res) {
                    this.filesPath.splice(index, 1)
                    service.removeFile({ id: this.id, file: file }, this.origin)
                }
            })
        }
    },
    computed: { },
    watch: {
        id(val) {
            this.findFile(val) 
        },
    },
    components: {
        'upload-component': require('vue-upload-component'),
    },
}
</script>

<style lang="scss" scoped>
    .disabled {
        pointer-events: none;
    }

    .disable-pointer:hover {
        cursor: context-menu;
    }

    #upload-component:disabled {
        pointer-events: none;
    }

    #id-message {
        text-align: left;
        margin-left: 100px;
    }

    .file {
        display: flex;
        justify-content: space-between;

        .waiting-list, .saved-list {
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .waiting-list {
            justify-content: flex-start;

            .waiting-file {
                text-align: left;
            }
        }

        .saved-list {
            list-style: none;
            justify-content: flex-end;
            position: initial;

            .saved-file {
                text-align: right;

                .icon-remove {
                    color: #ff4545;

                    &:hover {
                        color: #751f1ff2;
                    }
                }
            }
        }

    }
    
    li {
        height: 34.67px;
    }

</style>
