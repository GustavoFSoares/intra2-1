<template>
        <div>
            <h1>{{ title }}</h1>

            <div class="reports-available">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-action">Cras justo odio</li>
                    <li class="list-group-item list-group-item-action">Dapibus ac facilisis in</li>
                    <li class="list-group-item list-group-item-action">Morbi leo risus</li>
                    <li class="list-group-item list-group-item-action">Porta ac consectetur ac</li>
                    <li class="list-group-item list-group-item-action">Vestibulum at eros</li>
                </ul>
            </div>

            <div class="report-content">
                


            </div>
        
        </div>
</template>
<script>
import { GooglePieChart } from "@/components/shared/chart/GooglePieChart";
export default {
    data() {
        return {
            title: 'Relatório Treinamentos'
        }
    }
}
</script>

<style lang="scss" scoped>
    .reports-available {
        position: fixed;

        display: flex;
        justify-content: flex-start;

        height: 100%;
    }

    li {

        &:hover {
            border-right: transparent;
            background-color: transparent;
        }


    }
</style>
