<template>    
    
    <div class="card panel">
        
        <transition name="panel-fade">
            <div class="panel-conteudo" v-show="visivel">
                <slot class="card-img-top">
                    
                </slot>
                <h2 class="card-title panel-title">{{ titulo }}</h2>
            </div>
        </transition>
    </div>

    
</template>

<script>
export default {
    props: ['titulo'],
    data() {
        return {
            visivel: true,
        }
    }
}
</script>

<style scoped>
   /* estilo do panel */ 

    .panel {
        width: 200px;
        height: 100%;
        padding: 0 auto;
        border: solid 1px grey;
        display: inline-block;
        margin: 5px;
        box-shadow: 5px 5px 10px grey;
        vertical-align: top;
        text-align: center;
    }

    .panel .panel-title {
        font-size: 18px;
    }

   /* .panel-fade-enter, .panel-fade-leave-active {
       opacity: 0;
   }

    .panel-fade-enter-active, .panel-fade-leave-active {
        transition: 1s;
    } */
</style>
