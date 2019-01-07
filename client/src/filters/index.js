import Vue from 'vue'
const moment = require('moment')

Vue.filter('formatSize', size => {
    if (size > 1024 * 1024 * 1024) {
        return (size / 1024 / 1024 / 1024).toFixed(2) + ' GB'
    } else if (size > 1024 * 1024) {
        return (size / 1024 / 1024).toFixed(2) + ' MB'
    } else if (size > 1024) {
        return (size / 1024).toFixed(2) + ' KB'
    }
    return size.toString() + ' B'
})
Vue.filter('humanizeDate', date => {
    return moment(date).format('DD/MM/YYYY HH:mm')
})