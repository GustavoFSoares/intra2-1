<template>
    <div id="alert">
        <div class="alert" :id='`${this.$props.type}-alert`' >
            <div :class='`card border-${this.$props.type}`'>
                <div class="card-body">
                    <h5 :class='`card-title text-${this.$props.type}`'>
                        {{ title.toUpperCase() }}
                    </h5>
                    <p class="card-text" v-html="description"></p>
                </div>
            </div>
        </div>
        <small>{{ type }}</small>
    </div>
</template>

<script>
export default {
    props: {
        type: '',
        title: { default: ' ' },
        description: '',
    },
}
</script>

<style scoped>
    small {
        display: none;
    }
</style>


