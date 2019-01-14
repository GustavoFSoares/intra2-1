<template>
    <div>
        <div class="card-header" data-toggle="collapse" :data-target="'#id-'+title" aria-expanded="true" :aria-controls="'id-'+title">
            <span class="btn">
               {{title}} <span v-if="trainings.length" class="badge badge-info"> {{ trainings.length }} </span>
            </span>
        </div>
        <div :id="'id-'+title" class="collapse">
            <alert-message id="alert" :type="training.return.type" :text="training.return.text" v-if="training.return" @close="training.return = ''"/>
            
            <div id="module-contents" class="list-group">
                <a v-for="(train, index) in trainings" :key="index" href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#trainingModal" @click="addSelected(train)">
                    <icon icon="clock" v-if="moment().diff(train.beginTime.date, 'days') == 0"/>
                    {{ train.id + ' - ' + train.name }}
                </a>
                <br v-if="!trainings">
                
                <div class="modal fade" id="trainingModal" tabindex="-1" role="dialog" aria-labelledby="trainingModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" v-if="training.selected">

                            <div class="modal-header">
                                <h5 class="modal-title" id="trainingModal">{{ training.selected.name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div>
                                    <div class="card-body">
                                        <h5 class="card-subtitle text-left text-muted mb-2">Palestrantes</h5>

                                        <span class="instructor" v-for="(instructor, index) of training.selected.instructors" :key="index">
                                            <div class="line">
                                                <cite class="pull-right">
                                                    {{ instructor.name }}
                                                </cite><br>
                                            </div>                                                    
                                        </span>
                                    </div>
                                    <hr id="hr">
                                </div>
                                <div class="row">
                                    <span class="col text-left"> <b>Início:</b> {{ moment(training.selected.beginTime.date).format('DD/MM/YYYY - HH:mm') }}</span>
                                    <span class="col"> <b>Carga Horária:</b> {{ training.selected.workload }}</span>
                                    <span class="col text-right"><b>Local:</b> {{ training.selected.enterprise }}</span>
                                </div>
                                <div class="row">
                                    <span class="col text-left"> <b>Final Previsto:</b> {{ moment(training.selected.endTime.date).format('DD/MM/YYYY - HH:mm') }}</span>
                                    <span v-if="training.selected.room" class="col text-right"> <b>Sala:</b> {{ training.selected.room.name }}</span>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal" @click="enterOnTraining(training.selected.id)">Participar</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>    

        </div>
    </div>
</template>

<script>
import moment from "moment";
import AlertMessage from "@/components/shared/AlertMessage";
import Message from "@/entity/AlertMessage";
import model, { getter } from "@/model/training-model";
const ModelTrainingParticipant = require("@/model/training-participant-model").default;

export default {
    props: {
        title: ''
    },
    data() {
        return {
            training: { selected: '', return: '' },
            subtitles: {
                training: "Treinamentos",
                news: "News",
            },
            trainings: '',
            moment: moment,
        }
    },
    methods: {
        enterOnTraining(trainingId) {
            ModelTrainingParticipant.addParticipant(trainingId, this.$session.get('user')).then(res => {
                this.training.return = new Message(res)
                
                if(res.id == 'training_add') {
                    setTimeout(() => {
                        this.$router.go();  
                    }, 1000);
                }
                
            })
        },
        addSelected(training) {
            let workload = model.getWorkloadObject(training.workload)
            training.workload = `${workload.hour}:${workload.minute}`
            this.training.selected = training
        }
    },
    mounted() {
        getter.getTrainingsUnrealized().then(res => { this.trainings = res })
    },
    components: {
        'alert-message': AlertMessage,
    }
}
</script>

<style scoped>
    .card-header {
        border: solid 1px grey;
        box-shadow: 5px 5px 10px grey;
   }

   div :not(#trainings) .card-header {
       margin-top: 5px;
   }

    #module-contents {
        margin-right: 7px;
    }

    #alert {
        position: relative;
        display: block;
    }

    #hr {
        margin-top: -1rem;
    }
</style>
