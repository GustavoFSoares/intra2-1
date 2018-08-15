<template>
    <div>
        <div class="card">
            <div id="trainings">
                <notification-trainings :title="subtitles.training"/>
            </div>

            <div id="news">
                <!-- <notification-news :title="subtitles.news"/> -->
            </div>
        </div>
    </div>
</template>

<script>
import NotificationTrainings from "./Notifications/Trainings.vue";
import NotificationNews from "./Notifications/News.vue";

export default {
    data() {
        return {
            subtitles: {
                training: "Treinamentos",
                news: "News",
            },
        }
    },
    components: {
        'notification-trainings': NotificationTrainings,
        'notification-news': NotificationNews,
    }
}
</script>

<style>
   .card-header {
        border: solid 1px grey;
        box-shadow: 5px 5px 10px grey;
   }

   div :not(#trainings) .card-header {
       margin-top: 5px;
   }
</style>
