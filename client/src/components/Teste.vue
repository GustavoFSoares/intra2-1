<template>
    <div class="container-fluid">
        <BR/>
        <div id = "carrosel">
            <carosel :values="values.carrosel"/>
        </div>
        
        <!-- <br/><br/><br/><br/><br/><br/><br/> -->

        <div class="row grid-container">
            <div id="module">
                <modules-list :values="values.modulos"/>
            </div>

            <div id="content">
                batatabatatabatatabatatabatatabatatabatatabatataba batatabatatabatatabatatabatatabatatabatatabatataba batatabatatabatatabatatabatatabatatabatatabatataba batatabatatabatatabatatabatatabatatabatatabatataba batatabatatabatatabatatabatatabatatabatatabatataba
            </div>

            <div id="notification">
                <notifications-list :values="values.avisos"/>
            </div>
        </div>
            
    </div>
</template>

<script>
import $ from "jquery";

import Carousel from "@/components/shared/Carousel.vue";
import ModuleList from "./Teste/Module-List.vue";
import NotificationList from "./Teste/Notification-List.vue";

export default {
    data() {
        return {
            values: {
                carrosel: [
                    { name: "Veia", link: "https://cdn-images-1.medium.com/max/1600/1*fVT1rv-DaEI1228tsvBYuw.jpeg" },
                    { name: "Mago Implacavel", link: "https://s1-ssl.dmcdn.net/O-0d0/x240-B2U.jpg"},
                    { name: "Ah Negao", link: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTuoXRYf_014uUfDhSrghKnW5qCncX7gAgSOx3foLhFqnTBbqOxdg"},
                ],
                modulos: [
                    { name: "Ramal", icon: "phone"},
                    { name: "Usuário", icon: "users"},
                    { name: "Convênio", icon: "handshake"},
                    { name: "Convênio", icon: "handshake"},
                ],
                avisos: [
                    { name: "Treinamentos" },
                    { name: "News" },
                ]
            }
        }
    }, 
    methods: {
        click() {
            $("#module-contents").toggleClass('in')
            $("#icon").toggleClass('in')
        }
    },
    computed: {
        style() {
            return (this.values.modulos.length * 50)/2
        }   
    },
    components: {
        'carosel': Carousel,
        'modules-list': ModuleList,
        'notifications-list': NotificationList,
    }
}
</script>

<style scoped>
    #module {
        position:absolute;
        grid-area: module;
    }

    #content {
        grid-area: content;
    }

    @media (min-width: 1400px) {
        #content {
            /* color: purple; */
            max-width: 1000px;
            min-width: 1000px;
        }
    }
    
    @media (min-width: 1200px) and (max-width: 1400px) {
        #content {
            /* color: green; */
            max-width: 620px;
            min-width: 620px;
        }
    }
    
    @media (min-width: 1090px) and (max-width: 1200px) {
        #content {
            /* color: blue; */
            max-width: 530px;
            min-width: 530px;
        }
    }
    
    @media (min-width: 800px) and (max-width: 1090px) {
        #content {
            /* color: red; */
            max-width: 420px;
            min-width: 420px;
        }
    }

    #notification {
        grid-area: notification;

        max-width: 300px;
        min-width: 300px;
    }

    .grid-container {
        margin-top: 20px;

        display: grid;
        
        align-content: end;
        grid-template-areas:
            'module content notification';
        grid-gap: 10px;
        grid-template-columns: 1fr auto;
        align-content: start;
    }
    
    div {
        outline: 1px dotted gray;
    }

</style>