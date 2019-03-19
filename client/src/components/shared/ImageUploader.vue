<template>
    <div>
        <div class="image" >
            <div class="image-container">
                <div class="image-border">
                    <img class="file" :src="imagePath" alt="link-logo"/>
                    <div class="icon-container">
                        <div class="box-icon" v-if="imageName" @click="click()">
                            <icon icon="plus-circle" size="4x" />
                        </div>
                        <div class="box-icon" v-else @mouseover="lock = true" @mouseout="lock = false">
                            <icon icon="lock" size="4x" />
                        </div>
                    </div>
                </div>
                <div v-if="lock">
                    <p class="alert alert-danger">Necessáio definir um nome para imagem</p>
                </div>
            </div>
        </div>
        <div class="buttons" v-show="path && saved == false">
            <div class="button-content">
                <button class="btn button-acept" @click="aceptImage()"> <icon class="icon" icon="check"/> </button>
            </div>
            <div class="button-content">
                <button class="btn button-decline" @click="cleanImage()"> <icon class="icon" icon="times"/> </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            path: null,
            file: null,
            lock: false,
            saved: true,
        }
    },
    props: {
        value: '',
        imageName: '',
        imageDefault: { default: 'https://image.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-260nw-1037719192.jpg' },
        submit_method: '',
    },
    watch: {
        value(val) {
            if(val.substr(0, 11) == "/static/img") {
                this.path = val
            }
        }
    },
    methods: {
        click() {
            this.getImage().then(res => {
                this.file = res
            })
        },
        async getImage() {
            this.cleanImage()

            let el = document.createElement("input")
            el.setAttribute("type", "file")
            
            return await new Promise(resolve => {
                el.addEventListener('input', event => {
                    let file = el.files[0]
                    
                    let reader = new FileReader();
                    reader.onload = () => {
                        this.path = reader.result
                    }
                    reader.readAsDataURL(file)

                    resolve(file)
                })
                el.click()
            })
        },
        aceptImage() {
            let formData = new FormData()
            formData.append('file', this.file);
            
            this.submit_method(this.imageName, formData).then(res => {
                this.saved = true
                this.$emit( 'input', res )
            })
        },
        cleanImage() {
            this.path = null
            this.file = null
            this.saved = false
        }
    },
    computed: {
        imagePath() {
            if(this.path) {
                return this.path
            } else {
                return this.imageDefault
            }
        }
    }
}
</script>

<style lang="scss" scoped>
    $borderRaius: 20px;
    @mixin style-button($color: var(--font-color) ) {
        color: $color;
        border-color: $color;

        &:hover {
            color: white;
            background-color: $color;
        }
    }

    .image {
        display: flex;
        align-items: center;
        justify-content: center;

        .image-border {

            position: relative;
            padding: 2px;
            
            border-radius: calc(#{$borderRaius} /2);
            border: 1px solid transparent;
            
            background-color: transparent;

            border-color: var(--font-color);

            min-width: 400px;
            min-height: 200px;

            &::before {
                transition: all 0.7s;
                top:0px;
                bottom:0px;
                left:0px;
                right:0px;
                
                content:'';
                position: absolute;
            }

            &:hover::before {
                border-radius: calc(#{$borderRaius} /2);
                background-color: #cacaca91;
                border-color: #cacaca91;
            }

            &:hover .icon-container {
                transition: all 0.7s;
                display: initial;
            }

            .file {
                padding: 7px;
                border-radius: $borderRaius;

                z-index: 0;
                width: 400px;
                height: 200px;
            }

            .icon-container {

                display: none;

                .box-icon {
                    position: absolute;
                    content: '';
                    
                    display: flex;
                    align-items: center;
                    justify-content: center;

                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                }

            }
        }

    }

    .buttons {
        display: flex;
        justify-content: center;

        .button-content {
            padding: 0.5rem;
            
            button {
                border-radius: 30px;
                background-color: transparent;
                border: 1px solid transparent;

                width: 3em;
                height: 3em;

                display: flex;
                align-items: center;
                justify-content: center;

                &.button-acept {
                    @include style-button( var(--success) );
                }

                &.button-decline {
                    @include style-button( var(--danger) )
                }

                .icon {
                    width: 1.3em;
                    height: 1.3em;
                }
            }

        }
    }

    #file-input {
        display: none;
    }
</style>
