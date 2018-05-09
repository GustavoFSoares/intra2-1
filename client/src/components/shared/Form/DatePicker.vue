<template>
    <div>
        <slot>

        </slot>
    </div>
</template>

<script>
import $ from "jquery"
import moment from 'moment'
import 'daterangepicker'
import 'daterangepicker/daterangepicker.css'

export default {
    props: {
        multiple: { default: false },
        onlycalendar: { default: false },
        opens: { default: "right" },
        maxdate: { default: moment.now() }
    },
    data() {
        return {
            minuteInterval: 5,
            hour24: true, 
            drops: "up",
            locale: {
                format: "DD/MM/YYYY - HH:mm",
                separator: " - ",
                applyLabel: "Ok",
                cancelLabel: "Cancelar",
                firstDay: 0,
                monthNames: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro" ],
                daysOfWeek: [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb" ],
            },

        }
    }, 
    mounted() {
        $('#picker').daterangepicker({ "autoUpdateInput": true, "alwaysShowCalendars": true, "singleDatePicker": !this._props.multiple, "timePicker": !this._props.onlycalendar, "timePicker24Hour": this.hour24, "timePickerIncrement": this.minuteInterval, "startDate": moment.now(), "opens": this._props.opens, "drops": this.drops, "locale": this.locale, "maxDate": this.configureLimitDate() });
    },
    methods: {
        configureLimitDate() {
            if(this._props.maxdate){
                let date = new Date(this._props.maxdate);
                return `${date.getDate()}/${date.getMonth()+1}/${date.getFullYear()} - 23:59`
            } else {
                return null
            }
        }
    }
}
</script>

<style scoped>

</style>