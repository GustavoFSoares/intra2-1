<template>
    <div class="container-fluid">
        
        <div class="row grid-container">
            <div id="module">
                <modules-list/>
            </div>

            <div id="content">
                <row>
                    <schedule/>
                </row>
            </div>

            <div id="notification">
                <notifications-list/>
            </div>
        </div>
            
    </div>
</template>

<script>
import ModuleList from "@/components/modules/Panel.vue";
import NotificationList from "./Notification-List.vue";
import Schedule from "./Schedule.vue";
import { FormRw, FormRws } from "@/components/shared/Form";

export default {
    data() {
        return {

        }
    }, 
    components: {
        'modules-list': ModuleList,
        'notifications-list': NotificationList,
        'schedule': Schedule,
        'row': FormRw,
    }
}
</script>

<style scoped>
    .container-fluid {
        margin-top: 15px;
    }

    #module {
        position:absolute;
        grid-area: module;
    }

    #content {
        grid-area: content;
    }

    #notification {
        grid-area: notification;
        
        max-width: 300px;
        min-width: 300px;
    }
    
    @media (min-width: 1400px) {
        #content {
            max-width: 990px;
            min-width: 990px;
        }
    }
    
    @media (min-width: 1200px) and (max-width: 1400px) {
        #content {
            max-width: 620px;
            min-width: 620px;
        }
    }
    
    @media (min-width: 1090px) and (max-width: 1200px) {
        #content {
            max-width: 530px;
            min-width: 530px;
        }
    }
    
    @media (min-width: 800px) and (max-width: 1090px) {
        #content {
            max-width: 500px;
            min-width: 500px;
        }

        #notification {
            max-width: 200px;
            min-width: 200px;
        }
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
    
</style>