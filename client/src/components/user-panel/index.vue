<template>
    <div class="container-fluid">
        <panel-modules id="panel-modules" :group="user.group.groupId"/>
    </div>
</template>

<script>
import PanelModules from "@/components/modules/Panel";
import User from "@/entity/User";
export default {
    data() {
        return {
            title: "Painel de Usuário",
            user: new User(this.$session.get('user')),
        }
    },
    components: {
        'panel-modules': PanelModules
    },
    mounted() {
        document.getElementById('music').volume = 1
    }

}
</script>

<style scoped>
    #panel-modules {
        margin-top: 1%;
    }
</style>
