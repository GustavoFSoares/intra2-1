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
        id: '',
        multiple: { default: false },
        onlycalendar: { default: false },
        opens: { default: "right" },
        maxdate: "",
        mindate: "",
    },
    data() {
        return {
            autoApply: true,
            begindate: '',
            finaldate: '',
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
        this.loadValues()
    },
    updated() {
        this.loadValues()
        
    },
    methods: {
        configureFinalDate() {
            this.finaldate = this.getTime(this.$props.maxdate)
            if(this.finaldate){
                let date = new Date(this.finaldate);
                return `${date.getDate()}/${date.getMonth()+1}/${date.getFullYear()} - 23:59`
            } else {
                return null
            }
        },
        configureBeginDate() {
            this.begindate = this.getTime(this.$props.mindate)
            if(this.begindate){
                let date = new Date(this.begindate);
                return `${date.getDate()}/${date.getMonth()+1}/${date.getFullYear()} - 00:00`
            } else {
                return null
            }
        },
        getTime(timename) {
            switch (timename) {
                case "now":
                    return moment.now()
                    break;
            
                case "tomorrow":
                    return moment(new Date()).add(1, 'days')
                    break;
            
                default:
                    return ""
                    break;
            }
        },
        loadValues() {
            $(`#${this.$props.id}`).daterangepicker({ "startDate": moment.now(), "endDate": moment.now(), "autoApply": true, "autoUpdateInput": true, "alwaysShowCalendars": true, "singleDatePicker": !this.$props.multiple, "timePicker": !this.$props.onlycalendar, "timePicker24Hour": this.hour24, "timePickerIncrement": this.minuteInterval, "opens": this.$props.opens, "drops": this.drops, "locale": this.locale, "minDate": this.configureBeginDate(), "maxDate": this.configureFinalDate() });
        }
    }
}
</script>

<style scoped>

</style>