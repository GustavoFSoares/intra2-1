<template>
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-11">
                <v-select label="name" :options="availables" v-model="checked"/>
            </div>
            <div class="col" id="play" :disabled="!checked"  @click="playRotine(checked)">
                <router-link class="play-icon" to="">
                    <icon icon="play"/>
                </router-link>
            </div>

        </div>
    </div>
</template>

<script>
import model, { getter } from "@/model/rotines-model";
import { FormRw, FormRws, VueSelect } from "@/components/shared/Form";

export default {
    data() {
        return {
            availables: [],
            checked: ''
        }
    },
    methods: { 
        playRotine(rotine) {
            this.checked = '';
            model.execute(rotine)
            setTimeout(() => {
                this.$emit('insert')
            }, 1500);
        }
    },
    mounted() {
        getter.getAvailableRotines().then(res => { 
            this.availables = res
        })
    },
    components: {
        'v-select': VueSelect,
    }
}
</script>

<style scoped>
    #play {
        margin-top: 8px;
    }

    #play[disabled="disabled"] {
        pointer-events: none;
    }

    #play[disabled="disabled"] .play-icon {
        color: rgba(1, 1, 212, 0.315);
    }
</style>
