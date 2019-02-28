<template>
    <div>
        <router-link @click.native="click" to=""> 
            <icon id="icon" icon="arrow-circle-right" class="in"/>
        </router-link>

        <div id="module-contents" class="list-group in">
            <router-link v-for="(module, index) in modules" :key="index" :to="{name: module.routeName}" class="list-group-item list-group-item-action">
                <icon :icon="module.icon"/> {{ module.name }}
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
        }
    },
    mounted() {
        getter.getModulesByGroup(this.$session.get('user').group.groupId).then(res => { this.modules = res })
    }
}
</script>

<style lang="scss" scoped>
    #icon {
        color: black;
        margin-left: 4px;
        transition: all 0.5s ease;

        &.in {
            transform: rotate(90deg);
        }
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

        &.in {
            width: 240px;
        }
    }
</style>
