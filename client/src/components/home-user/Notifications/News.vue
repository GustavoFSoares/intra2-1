<template>
    <div>
        <div class="card-header" data-toggle="collapse" :data-target="'#id'+title" aria-expanded="true" :aria-controls="'id'+title">
            <span class="btn">
                {{title}}
            </span>
        </div>
        <div :id="'id'+title" class="collapse">
            <div class="card-body">
                <slot>

                </slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: ''
    },
}
</script>

<style scoped>
    .card-header {
        border: solid 1px grey;
        box-shadow: 5px 5px 10px grey;
   }

   div :not(#trainings) .card-header {
       margin-top: 5px;
   }
</style>
