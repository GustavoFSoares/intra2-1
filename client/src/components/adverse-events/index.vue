<template>
    <div class="container">
        <h1>{{ title }}</h1>
        <div class="row">

            <div class="col-md-4 order-md-2 mb-4">
                <router-link class="btn btn-outline-primary btn-lg" id="submit" to="/eventos-adversos/relatar">Criar Relato</router-link>
            </div>

            <div class="col-md-8 order-md-1">
                
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            title: "Eventos Adversos"
        }
    },
    components: {
        
    },
    mounted(){
        
    }
}
</script>

<style scoped>
    #submit {
        display: block;
        position: fixed;
        top: 60%;
        margin-left: 5%;
    }
</style>


