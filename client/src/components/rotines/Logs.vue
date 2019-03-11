<template>
    <div class="container-fluid">

        <row>
            <h2 id="title">
                {{rotine.file}}
                <span class="text-warning" v-if="!rotine.timeEnd && rotine">(Em Andamento)</span>
            </h2>
        </row>

        <hr>
        <div class='row'>
            <rows  class="col-md-4">
                <div id="content">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">#{{ rotine.id }} - {{ rotine.name }}</h6>
                            <p class="card-text">
                                <span class="label">Origem:</span>
                                <span class="value">{{ rotine.from }}</span>
                            </p>
                            <p class="card-text">
                                <span class="label">Local de Registro:</span>
                                <span class="value">{{ rotine.target }}</span>
                            </p>
                            <p class="card-text">
                                <span class="label">Horário Início:</span>
                                <span class="value">{{ rotine.timeBegin.date }}</span>
                            </p>
                            <p class="card-text">
                                <span class="label">Horário Fim:</span>
                                <span v-if="rotine.timeEnd" class="value">{{ rotine.timeEnd.date }}</span>
                            </p>
                            <p class="card-text">
                                <span class="label">Registros:</span>
                                <span class="value">{{ rotine.logs.length }}</span>
                            </p>
                        </div>

                    </div>
                </div>
                <div id="goback-button">
                    <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'rotinas'}" tag="button">
                        Voltar
                    </router-link>
                </div>
            </rows>
            
            <rows>
                <div id="logs">
                            <div class="card">
                                <div class="card-body historic">
                                    <div class="">
                                        <span class="historic-body" v-for="(line, index) of rotine.logs" :key="index">
                                            <span class="pull-left">{{ index }}</span>
                                            <span class="pull-center line">{{ line }}</span><br><hr>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
            </rows>
        </div>
        
    </div>
</template>

<script>
import { FormRw, FormRws } from "@/components/shared/Form";
import model, { getter } from "@/model/rotines-model";

export default {
    data() {
        return {
            id: this.$route.params.id,
            rotine: {
                logs: [],
                timeBegin: '',
                timeEnd: true,
            }
        }
    },
    mounted() {
        getter.getLogsByRotine(this.id).then(res => { this.rotine = res; console.log(res); })
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
    }
}
</script>

<style lang="scss" scoped>
    #title {
        margin-top: 2%;
        margin-left: 8%;
    }

    #content {
        text-align: left;
        position: fixed;
        display: flex;
    }

    #goback-button {
        margin-top: 300px;
        margin-left: 120px;
        position: fixed;
        display: flex;
    }

    .card-text .value {
        color: rgba(0, 0, 0, 0.575);
    }

    .historic {
        background-color: rgba(224, 224, 224, 0.253);
    }

    .historic-body {
        font-size: 15px;

        .time {
            color: rgb(8, 184, 8);
        }

        .line {
            text-align: center;
        }
    }

    #logs hr {
        margin-top: 2px;
        margin-bottom: 2px;
    }
</style>
