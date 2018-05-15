<template>
    <div class="container">
        <h1>{{ title }}</h1>
        <div class="row">

            <div class="col-md-4 order-md-2 mb-4">
                <div id="send">
                    <row>
                        <!-- <button class="button btn btn-outline-primary btn-lg" id="back-button" type="button" :disabled="options.disabled">
                            Voltar
                        </button> -->
                        <router-link class="button btn btn-outline-primary btn-lg" id="next-button" to="/eventos-adversos/relatar">Criar Evento</router-link>
                    </row>
                </div>
                
            </div>

            <div class="col-md-8 order-md-1">
            
                <div id="what-is-it">
                    <row :text_left="false">
                        <div class="card border-primary" style="">

                            <div class="card-body">
                                <h5 class="card-title text-primary">{{card.whatIsIt.title}}</h5>
                                <div class="row">
                                    <div class="col-10">
                                        <p class="card-text">{{card.whatIsIt.text}}</p>
                                    </div>
                                    <div class="col col-sm-1 col-xs-1">
                                        <img id="interrogation-icon" src="@/../static/img/signals/interrogation.png" alt="?">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </row>

                </div>

                <div id="divided-by">
                    <row :text_left="false">
                        <div class="container">
                        
                            <div class="justify-content-center">
                                <div class="subtopic">
                                    <div>
                                        <img id="division-icon" class="col-md" src="@/../static/img/signals/division.png" alt="">
                                        <span id="division-text">
                                            São divididos em:
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </row>
                </div>

                <div id="adverse-events">
                    <row>

                        <div class="card-deck">

                            <div class="card border-danger" style="max-width: 15rem">
                                <div class="card-body">
                                    <h5 class="card-title text-danger">{{card.adverseEvents.title}}</h5>
                                    <p class="card-text">{{card.adverseEvents.text}}</p>
                                    <small class="">{{card.adverseEvents.complement}}</small>
                                </div>
                            </div>
                            
                            <div class="card border-success" style="max-width: 29rem">
                                <div class="card-body">
                                    <h5 class="card-title text-success">{{card.almostFailed.title}}</h5>
                                    <p class="card-text">{{card.almostFailed.text}}</p>
                                    <small class="">{{card.almostFailed.complement}}</small>
                                </div>
                            </div>

                        </div>    

                    </row>
                </div>

                <div id="procedural-errors">
                    <row>

                        <div class="card border-purple" style="">
                            <div class="card-body">
                                <h5 class="card-title text-purple">{{card.proceduralError.title}}</h5>
                                <p class="card-text">{{card.proceduralError.text}}</p>
                                <small class="">{{card.proceduralError.complement}}</small>
                            </div>
                        </div>
                        
                    </row>
                </div>

                <div id="sentinel-events">
                    <row>

                        <div class="card-deck">

                            <div class="card border-info" style="max-width: 24rem">
                                <div class="card-body">
                                    <h5 class="card-title text-info">{{card.sentinelEvents.title}}</h5>
                                    <p class="card-text">{{card.sentinelEvents.text}}</p>
                                    <small class="">{{card.sentinelEvents.complement}}</small>
                                </div>
                            </div>
                            <div class="card border-warning" style="max-width: 21rem">
                                <div class="card-body">
                                    <h5 class="card-title text-warning">{{card.technicalComplaints.title}}</h5>
                                    <p class="card-text">{{card.technicalComplaints.text}}</p>
                                    <small class="">{{card.technicalComplaints.complement}}</small>
                                </div>
                            </div>

                        </div>    

                    </row>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
import { FormRw } from "@/components/shared/Form";
export default {
    data(){
        return {
            title: "Notificação de Incidentes",
            card: {
                whatIsIt: {
                    title: "O que são?",
                    text: "São eventos que poderiam ter resultado ou resultaram em dano desnecessário ao paciente."
                },
                adverseEvents: {
                    title: "Eventos Adversos:",
                    text: "Incidentes que resultam em dano ao paciente.",
                    complement: "Ex: Flebite, Quedas."
                },
                almostFailed: {
                    title: "Quase Falha:",
                    text: "São falhas processuais que quase atingiram o paciente.",
                    complement: "Ex: Prescrição de medicamentos inadequada antes de ser administrada foi identificada a falha pela equipe."
                },
                proceduralError: {
                    title: "Erros de Processos:",
                    text: "Falha no fluxo ou na realização de processos assistenciais ou administrativos dentro da instituição.",
                    complement: "Ex: Atraso na realização de RX, Atraso na Entrega de Roupas."
                },
                sentinelEvents: {
                    title: "Eventos Sentinelas:",
                    text: "Eventos Adversos com danos irreversíveis aos pacientes.",
                    complement: "Ex: Cirurgia em paciente errado, Cirurgia em local incorreto, Óbito Inesperado."
                },
                technicalComplaints: {
                    title: "Queixas Técnicas:",
                    text: "Falha em materiais, medicamentos ou em equipamentos.",
                    // complement: "Ex: Prescrição de medicamentos inadequada antes de ser administrada foi identificada a falha pela equipe."
                },
            }
        }
    },
    components: {
        row: FormRw
    },
    mounted(){ }
}
</script>

<style scoped>
    #send {
        margin-left: 35px;
    }

    .button {
        display: block;
        position: fixed;
    }

    .button #next-button {
        margin-top: 60px;
        margin-left: 3%;
    }

    .text-purple {
        color: #6f42c1 !important;
    }

    .border-purple {
        border-color: #6f42c1 !important;
    }

    img {
        width: 70px;
        height: 70px;
    }

    #interrogation-icon {
        margin-top: -30%;
    }

    #division-icon {
        flex-grow: 1;
        display: flex;
        margin-left: 20%;
    }

    #division-text {
        flex-grow: 1;
        display: flex;
        margin-top: -7%;
        margin-left: 40%;
        font-size: 25px
    }


</style>