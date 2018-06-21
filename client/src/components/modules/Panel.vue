<template>
    <div>
        <div v-if="modules" class="pull-left">
         
            <div v-for="module of modules" :key="module.id" class="panel card">
                <router-link :to="{name: module.routeName}" class="nav-link panel-conteudo">
                    <i :class="module.icon">
                        <h2 class="card-title panel-title">{{ module.name }}</h2>
                    </i>    
                </router-link>
            </div>

        </div>

        <div v-else>
            <h1>Sem módulos</h1>
        </div>
    </div>
</template>

<script>
import model from "@/model/modules-model";
export default {
    props: {
        group: String,
    },
    data() {
        return {
            visivel: true,
            modules: '',
        }
    },
    mounted() {
        model.getModulesByGroup(this.$props.group).then(res => { this.modules = res })
    }
}
</script>

<style scoped>
    .panel {
        /* width: auto; */
        max-width: 140px;
        min-width: 100px;
        
        height: 110px;
        
        border: solid 1px grey;
        box-shadow: 2px 2px 2px grey;
        margin: 5px;
        padding: 0 auto;
        
        display: inline-flex;
        vertical-align: top;
        text-align: center;
        background-color: #adabab57;
    }

    .panel-title {
        margin-top: 10px;
        font-size: 18px;
    }

    .panel-conteudo {
        color: #575757d3;

    }

    .panel-conteudo i {
        font-size: 30px;
        margin-top: 10px;
    }

</style>
