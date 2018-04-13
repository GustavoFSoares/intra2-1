<template>
    <div id="app">
        <nav-bar/>
        
        <div>
            <img id="logo" class="rounded mx-auto d-block" src="@/../static/img/logo-gamp.jpg">
        </div>

        <router-view/>
        <footer-app/>
    </div>
</template>

<script>
import NavBar from '@/components/NavBar.vue'
import Footer from '@/components/Footer.vue'
export default {

    name: 'App',
    components: {
        'nav-bar': NavBar,
        'footer-app': Footer,
    }

}
</script>

<style>
    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        /* margin-top: 60px; */
        margin-bottom: 100px;
    }

    #logo {
        width: 20%;
        height: 20%;
        margin-bottom: 10px;
        margin: 4px;
        padding: 5px 5px 5px 5px;
    }
</style>
