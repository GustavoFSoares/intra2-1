<template>    

    <div class="card panel">
            <router-link :to="test.path" class="panel-conteudo nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i :class="test.class+' font'"></i>    
                <h2 class="card-title panel-title font">{{ test.label }}</h2>
            </router-link>
            <div v-if="test.submenu" class="dropdown-menu">
                <router-link v-for="(link, index) in test.submenu" :key="index" class="dropdown-item" :to="link.path">{{link.label}}</router-link>
            </div>

    </div>
</template>

<script>
export default {
    props: {
        titulo: { default: "TESTE" },
        test: '',
    },
    data() {
        return {
            visivel: true,
        }
    },
    mounted() { }
}
</script>

<style scoped>
    .panel {
        width: 120px;
        height: 100px;
        padding: 0 auto;
        border: solid 1px grey;
        display: inline-flex;
        margin: 5px;
        box-shadow: 2px 2px 2px grey;
        vertical-align: top;
        text-align: center;
        background-color: #adabab57;
    }

    .panel-title {
        margin-top: 15%;
        font-size: 18px;
    }

    .panel-conteudo i {
        font-size: 30px;
        margin-top: 15%;
        display: absolute;
    }

    .font {
        color: #575757d3
    }
</style>
