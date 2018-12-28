<template>
    <div>
        <section>
            <div class="card border-secondary">
                <div class="card-body">
                    
                    <row v-if="!ombudsman.managerResponse">
                        <div>
                            <h5 class="subtitle text-left">Informação do Responsável da Área:</h5>
                        </div>
                        <textarea name="Ombudsman-ombudsman-description" class="form-control" cols="30" rows="4" v-model="managerResponse" placeholder="Resposta do Gestor Responsável: "></textarea>
                    </row>
                    <row v-else>
                        <h6 class="card-subtitle mb-2 text-muted">Resposta do Responsável:</h6>
                        <p class="card-text">
                            {{ ombudsman.managerResponse }}
                        </p>
                    </row>

                </div>
            
                <blockquote class="blockquote pull-right signature">
                    <footer class="blockquote-footer">Gestor Responsável: 
                        <cite v-if="ombudsman.manager" title="Source Title"><b>{{ manager.name }}</b></cite>
                    </footer>
                </blockquote>
            </div>
        </section>
        
        <section v-if="ombudsman.ombudsmanToResponse" class="mt-3">
            
             <div class="card border-secondary">
                <div class="card-body">

                    <row>
                        <h6 class="card-subtitle mb-2 text-muted">Resposta da Ouvidoria:</h6>
                        <p class="card-text">
                            {{ ombudsman.responseToUser }}
                        </p>
                    </row>

                </div>
                
                <blockquote class="blockquote pull-right signature">
                    <footer class="blockquote-footer">Gestor Responsável: 
                        <cite title="Source Title"><b>{{ ombudsman.ombudsmanToResponse.name }}</b></cite>
                    </footer>
                </blockquote>

             </div>
        </section>
    </div>
</template>

<script>
import model from "@/model/ombudsman-model";
import { FormRw } from "@/components/shared/Form";
export default {
    data() {
        return {
            manager: '',
            managerResponse: '',
        }
    },
    props: {
        ombudsman: '',
    },
    methods: {
        submit() {
            return model.setManagerResponse(this.ombudsman.id, { 'manager': this.manager, 'managerResponse': this.managerResponse })
        }
    },
    mounted() {
        this.manager = this.ombudsman.manager ? this.ombudsman.manager : this.$session.get('user')
    },
    components: {
        'row': FormRw,
    }
}
</script>
