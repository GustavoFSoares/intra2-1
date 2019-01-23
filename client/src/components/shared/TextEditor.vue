<template>
    <div id="box">
        <div id="text-js-editor"> </div>
    </div>
</template>

<script>
import Quill from "quill"
import 'quill/dist/quill.snow.css'

export default {
    props: {
        value: { default: '<p></p>'}
    },
    data: () => ({
        quill: {}
    }),
    watch: {
        value() {
            if( this.quill.root.innerHTML == "<p><br></p>" ) {
                this.quill.root.innerHTML = this.remove(this.value)
            }
        }
    },
    methods: {
        updateDate() {
            this.$emit('input', this.add(this.quill.root.innerHTML) )
        },
        add(txt) {
            return "<span class='text-editor'>"+txt+"</span>"
        },
        remove(txt) {
            return txt.replace("<span class='text-editor'>", "").replace("</span>", "")
        }
    },
    mounted() {
        this.quill = new Quill('#text-js-editor', {
            placeholder: 'Escreva...',
            theme: 'snow',
            modules: {
                toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],       // toggled buttons
                        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme

                        ['blockquote', 'code-block'],

                        // [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                        [{ 'direction': 'rtl' }],                         // text direction

                        
                        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                        [{ 'font': [] }],
                        [{ 'align': [] }],

                        ['clean']                                         // remove formatting button
                ],
            },
        });
        this.quill.root.innerHTML =this.value
        this.quill.on('text-change', () => {
            this.updateDate()
        });
    },
}
</script>

<style>
    #box {
        max-width: 650px;
    }

    div .ql-editor {
        min-height: 400px;
    }
</style>
