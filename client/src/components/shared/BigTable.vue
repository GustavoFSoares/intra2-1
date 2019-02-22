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
            hide: false,
            i: 0,
            rows: 0,
        }
    },
    methods: {
        init() {
            if( this.i == 0 && $('.table td').length != 0 ) {
                this.i++
                
                var $table = $('.table')
                
                var $fixedColumn = $table.clone()
                $fixedColumn.insertBefore($table).addClass('fixed-column new-table')
                $fixedColumn.find('th:not(:first-child),td:not(:first-child)').remove();
                
                let length = Number(this.field_length)+30
                $("#big-table").css("--length", length+"px")
                
                let $rows = $fixedColumn.find('tr')
                this.rows = $rows.length

                $rows.each(function (i, elem) {
                    $(this).height( $table.find('tr:eq(' + i + ')').height() );
                });
            }
        },
    },
    props: [ 'field_length' ],
    mounted() { },
    updated() {
        let actualLenth = $('.table:not(new-table) tr').length
        if( actualLenth != this.rows && actualLenth != 0) {
            let $newTable = $('.new-table tr')
            if($newTable.length == this.rows) {
                this.i = 0
                $('.new-table').remove()
            }
        }
        
        this.hide = $('#app').width() > $('.table:not(.new-table) tbody tr').width() ? true : false
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
        left: 0;
    }

    .hide .new-table {
        display: none;
    }

    .table tr th:first-child, td:first-child {
        min-width: var(--length);
    } 
</style>
