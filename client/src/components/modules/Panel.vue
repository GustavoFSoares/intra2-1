<template>
    <div>
        <router-link @click.native="click" to=""> 
            <icon id="icon" icon="arrow-circle-right" class="in"/>
        </router-link>

        <div id="module-contents" class="list-group in">
            <router-link :to="routeName(module)" v-for="(module, index) in modules" :key="index" class="list-group-item list-group-item-action" data-toggle="collapse" :data-target="'#id-'+module.id" aria-expanded="true" :aria-controls="'id-'+module.id">
                <icon :icon="module.icon"/> {{ module.name }}
                <div :id="'id-'+module.id" class="collapse">
                    <router-link v-for="(chield, index) in module.children" :key="index" :to="{name: chield.routeName}" class="list-group-item list-group-item-action chield-item">
                        <span class="chield-modules">
                            <icon :icon="chield.icon"/>
                            {{ chield.name }}
                        </span>
                    </router-link>
                </div>
            </router-link>
        </div>    
    </div>
</template>

<script>
import $ from "jquery";
import { getter } from "@/model/modules-model";

export default {
    data() {
        return {
            modules: ''
        }
    },
    methods: {
        click() {
            $("#module-contents").toggleClass('in')
            $("#icon").toggleClass('in')
        },
        routeName: (mod) => mod.children ? "" : { name: mod.routeName }
    },
    mounted() {
        getter.getModulesByGroup(this.$session.get('user').group.groupId).then(res => { this.modules = res })
    }
}
</script>

<style scoped>
    #icon {
        color: black;
        margin-left: 4px;
        transition: all 0.5s ease;
    }

    #icon.in {
        transform: rotate(90deg);
    }

    #module-contents {
        transition: width 0.5s ease;
        
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        vertical-align: middle;
        line-height: 30px;
        
        width: 0px;
        margin-left: 10px;

        max-width: 240px;
    }

    #module-contents.in {
        width: 240px;
    }

    .chield-modules {
        display: inline-block;
        overflow: hidden;
        vertical-align: middle;
        
        max-width: 170px;

    }

</style>
