<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <router-link class="navbar-brand" to="/">Home</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                <!-- <router-link class="nav-item nav-link active" to="/add">Add<span class="sr-only">(current)</span></router-link>
                <router-link class="nav-item nav-link disabled" to="/cv">Resume</router-link>
                <router-link class="nav-item nav-link disabled" to="/test">Teste</router-link> -->
                </div>
            </div>
        </nav>

    </div>
</template>

<script>
export default {
    data(){
        return {
            "message": ""
        }
    },
    methods: { }
}
</script>

<style scoped>

</style>


