<template>
    <div id="alert">
        <div class="alert" :id="style.id" >
            <div :class="style.border">
                <div class="card-body">
                    <h5 :class="style.title">{{ title }}</h5>
                    <p class="card-text">{{ description }}</p>
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
        title: '',
        description: '',
    },
    data() {
        return {
            style: {
                id: '',
                border: '',
                title: ''
            }
        }
    },
    methods: {
        loadStyle() {
            this.style.id = `${this.$props.type}-alert`
            this.style.border = `card border-${this.$props.type}`
            this.style.title = `card-title text-${this.$props.type}`
        }
    },
    created() {
        this.loadStyle()
    },
    updated() {
        this.loadStyle()
    }
}
</script>

<style scoped>
    small {
        display: none;
    }
</style>


