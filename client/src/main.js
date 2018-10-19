import Vue from 'vue'
import App from './App'

import VueResource from 'vue-resource'
import router from './routes'

import VueSession from 'vue-session'
import VueTheMask from 'vue-the-mask'
import VeeValidate, { Validator } from 'vee-validate';
import translate from 'vee-validate/dist/locale/pt_BR';

import Tooltip from 'vue-directive-tooltip';
import 'vue-directive-tooltip/css/index.css';
import '@/../static/directives-styles/VTooltip.css';

Vue.use(Tooltip);
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.js'
import 'font-awesome/css/font-awesome.css'

import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(fas)

Vue.component('icon', FontAwesomeIcon)

Vue.config.productionTip = false

Validator.localize('pt_BR', translate)
Vue.use(VueResource)
Vue.use(VueSession)
Vue.use(VueTheMask)
Vue.use(VeeValidate);

new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
