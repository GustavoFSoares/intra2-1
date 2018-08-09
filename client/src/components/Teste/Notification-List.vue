<template>
    <div id="module-contents">

        <div class="card" v-for="(not, index) in values" :key="index">
            <div class="card-header">
                <span class="btn" data-toggle="collapse" :data-target="'#id-'+index" aria-expanded="true" :aria-controls="'id-'+index">
                    {{not.name}}
                </span>
            </div>

            <div :id="'id-'+index" class="collapse">
                <div class="card-body">
                    {{not.name}} {{not.name}} {{not.name}}
                </div>
            </div>
        </div>

    </div>
</template>

<script>

export default {
    props: {
        values: '',
    },
}
</script>

<style scoped>
    /* #module-contents {
        min-width: 300px;
        max-width: 300px;
    } */
</style>
