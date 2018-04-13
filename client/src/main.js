import Vue from 'vue'
import App from './App'

import VueResource from 'vue-resource'
import router from './routes'

import BootstrapVue from 'bootstrap-vue'

// import '@/assets/css/bootstrap.css'
// import '@/assets/js/bootstrap.js'

import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.js'

Vue.config.productionTip = false

Vue.use(VueResource)
Vue.use(BootstrapVue)

new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
