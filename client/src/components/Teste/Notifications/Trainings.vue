<template>
    <div>
        <div class="card-header" data-toggle="collapse" :data-target="'#id-'+title" aria-expanded="true" :aria-controls="'id-'+title">
            <span class="btn">
                {{title}}
            </span>
        </div>
        <div :id="'id-'+title" class="collapse">
            <alert-message id="alert" :type="training.return.type" :text="training.return.text" v-if="training.return" @close="training.return = ''"/>
            
            <div id="module-contents" class="list-group">
                <a v-for="(train, index) in trainings" :key="index" href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#trainingModal" @click="training.selected = train">
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
                                <div class="row">
                                    <span class="col text-left"> <b>Multiplicador: </b>
                                        {{ training.selected.instructor.name }}
                                        <span>- {{ training.selected.instructor.group.name }}</span>
                                    </span>
                                </div>
                                <div class="row">
                                    <span class="col text-left"> <b>Horário:</b> {{ training.selected.timeTraining }}</span>
                                    <span class="col"> <b>Carga Horária:</b> {{ training.selected.workload }}</span>
                                    <span class="col text-right"><b>Local:</b> {{ training.selected.place }}</span>
                                </div>
                                <div class="row">
                                    
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
import AlertMessage from "@/components/shared/AlertMessage";
import Message from "@/entity/AlertMessage";
import model, { getter } from "@/model/training-model";
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
            trainings: ''
        }
    },
    methods: {
        enterOnTraining(trainingId) {
            model.addParticipant(trainingId, this.$session.get('user')).then(res => {
                this.training.return = new Message(res)
                
                if(res.id == 'training_add') {
                    setTimeout(() => {
                        this.$router.go();  
                    }, 1000);
                }
                
            })
        },
    },
    mounted() {
        getter.getTrainings().then(res => { this.trainings = res })
    },
    components: {
        'alert-message': AlertMessage,
    }
}
</script>

<style scoped>
    #module-contents {
        margin-right: 7px;
    }

    #alert {
        position: relative;
        display: block;
    }
</style>
