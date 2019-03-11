<template>
    <div class="col-md mb-3">
        <label v-if="label" :for="id" v-html="label+':'"></label>
        <slot>
            
        </slot>
    </div>
</template>

<script>
export default {
    props: {
        label: {String, default: false},
        id: String
    },

}
</script>