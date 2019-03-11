<template>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" :data-slide-to="index" v-for="(car, index) in values" :key="index"/>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item" v-bind:class="{'active' : index == 0}" v-for="(car, index) in values" :key="index">
                <img :src="car.link" :alt="car.name" height="200px" >
            </div>
        </div>
        
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>    
</template>

<script>
export default {
    props: {
        values: ''
    }
}
</script>