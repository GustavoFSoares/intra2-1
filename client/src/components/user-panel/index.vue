<template>
    <div class="container-fluid">
        <!-- <h1>{{ title }}</h1> -->
        <div id="panel" class="rounded float-left">
            <panel v-for="(text, index) in texts" :test="text" :key="index"/>
        </div>
    </div>
</template>

<script>
import Panel from "@/components/user-panel/Panel";
export default {
    data() {
        return {
            title: "Painel de Usuário",
            texts: [
                {
                    label: 'Texto1',
                    class: 'fa fa-times-circle',
                    path: '/alertas',
                    submenu: ''
                },
                {
                    label: 'Texto2',
                    class: 'fa fa-times-circle-o',
                    path: '/alertas',
                    submenu: ''
                },
                {
                    label: 'Texto3',
                    class: 'fa fa-window-close',
                    path: '/alertas',
                    submenu: ''
                },
                {
                    label: 'Texto4',
                    class: 'fa fa-umbrella',
                    path: '/alertas',
                    submenu: ''
                },
                {
                    label: 'Texto5',
                    class: 'fa fa-volume-down',
                    path: '',
                    submenu: [
                            { label: 'Test1', path: '/' }
                        ]
                },
                {
                    label: 'Texto6',
                    class: 'fa fa-upload',
                    path: '',
                    submenu: [
                            { label: 'Test1', path: '/' },
                            { label: 'Test2', path: '/' },
                        ]
                },
                {
                    label: 'Texto7',
                    class: 'fa fa-television',
                    path: '',
                    submenu: [
                            { label: 'Test1', path: '/' }
                        ]
                },
                {
                    label: 'Texto8',
                    class: 'fa fa-tasks',
                    path: '',
                    submenu: [
                            { label: 'Test1', path: '/' },
                            { label: 'Test2', path: '/' },
                            { label: 'Test3', path: '/' },
                        ]
                },
                {
                    label: 'Texto9',
                    class: 'fa fa-terminal',
                    path: '',
                    submenu: [
                            { label: 'Test1', path: '/' },
                        ]
                },
                {
                    label: 'Texto10',
                    class: 'fa fa-tree font',
                    path: '',
                    submenu: [
                            { label: 'Test1', path: '/' },
                        ]
                },
            ],
        }
    },
    components: {
        'panel': Panel
    },
    mounted() { }

}
</script>

<style scoped>
    #panel {
        margin-top: 1%;
        
    }
</style>
