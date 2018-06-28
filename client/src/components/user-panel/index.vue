<template>
    <div class="container-fluid">
        <div id="audio" v-if="user.id == 'victor.santos' || user.id == 'bruno.ghidini' || user.id == 'gustavo.soares'">
            <audio id="music" autoplay="autoplay">
                 <source src="@/../static/song/champions.mp3" type="audio/mpeg"> 
            </audio>
        </div>
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
        document.getElementById('music').volume = 0.02
    }

}
</script>

<style scoped>
    #panel-modules {
        margin-top: 1%;
    }
</style>
