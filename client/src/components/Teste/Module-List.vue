<template>
    <div>
        <router-link @click.native="click" to=""> 
            <icon id="icon" icon="arrow-circle-right" />
        </router-link>

        <div id="module-contents" class="list-group">
            <a v-for="(mod, index) in values" :key="index" href="#" class="list-group-item list-group-item-action">
                <icon :icon="mod.icon"/> {{ mod.name }}
            </a>
        </div>    
    </div>
</template>

<script>
import $ from "jquery";

export default {
    props: {
        values: '',
    },
    methods: {
        click() {
            $("#module-contents").toggleClass('in')
            $("#icon").toggleClass('in')
        }
    },
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
    }

    #module-contents.in {
        width: 200px;
    }
</style>
