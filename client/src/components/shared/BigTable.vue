<template>
    <div id="big-table" class="all table-responsive" v-bind:class="{ 'hide' : hide }">
        <table class="table">
            <slot>
                
                
                

            </slot>  
        </table>
    </div>
</template>

<script>
import $ from "jquery";
export default {
    data() {
        return {
            hide: false
        }
    },
    methods: {
        init() {
            var $table = $('.table')
            
            if( $table.has('td').length == 1 ) {
                this.hide = $('#app').width() > this.length ? true : false
                
                var $fixedColumn = $table.clone()
                $fixedColumn.insertBefore($table).addClass('fixed-column new-table')
                $fixedColumn.find('th:not(:last-child),td:not(:last-child)').remove();
                
                let length = $fixedColumn.width()+5

                $("#big-table").css("--length", length+"px")

                $fixedColumn.find('tr').each(function (i, elem) {
                    $(this).height($table.find('tr:eq(' + i + ')').height());
                });
            }
           
        }
    },
    props: [ 'length' ],
    mounted() {
        this.init()
    },
    updated() {
        this.init()
    },
}
</script>

<style scoped>
    #big-table {
        --length: 80px;
    }

    .all {
        text-align: initial;
        display: block;
        max-width: 100%;
        overflow-x: auto;
        white-space: nowrap;
    }

    .table-responsive > .fixed-column {
        position: absolute;
        display: inline-block;
        width: auto;
        border-right: 1px solid #ddd;
        background-color: white;
    }

    .table {
        text-align: center;
    }

    .new-table {
        right: 0;
    }

    .hide .new-table {
        display: none;
    }

    .table tr th:last-child, td:last-child {
        min-width: var(--length);
    } 
</style>
