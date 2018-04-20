import Vue from 'vue'
import App from './App'

import VueResource from 'vue-resource'
import router from './routes'

import VeeValidate, { Validator } from 'vee-validate';
import translate from 'vee-validate/dist/locale/pt_BR';

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.js'
import 'font-awesome/css/font-awesome.css'

Vue.config.productionTip = false

Validator.localize('pt_BR', translate)
Vue.use(VeeValidate);
Vue.use(VueResource)

new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
