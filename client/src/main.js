import Vue from 'vue'
import App from './App'

import VueResource from 'vue-resource'
import router from './routes'
require('./filters')

import * as uiv from 'uiv'
import Scrollspy from 'vue2-scrollspy';
import VueSession from 'vue-session'
import VueTheMask from 'vue-the-mask'
import VeeValidate, { Validator } from 'vee-validate';
import Tooltip from 'vue-directive-tooltip';

import locale from 'uiv/src/locale/lang/pt-BR'
import translate from 'vee-validate/dist/locale/pt_BR';

import 'bootstrap/dist/css/bootstrap.min.css'
import 'glyphicons-only-bootstrap/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'
import 'font-awesome/css/font-awesome.min.css'
import 'vue-directive-tooltip/src/css/index.scss';
import '@/../static/directives-styles/VTooltip.css';
import '@/../static/default-styles/TextEditor.styl'


import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { FormRw, FormRws, Require, VueSelect } from "@/components/shared/Form";

import Box from "@/components/shared/Box.vue";
import InfoIcon from "@/components/shared/InfoIcon.vue";
import SendingIcon from "@/components/shared/SendingIcon.vue";

library.add(fas)
Vue.component('box', Box)
Vue.component('icon', FontAwesomeIcon)
Vue.component('info-icon', InfoIcon)
Vue.component('sending-icon', SendingIcon)
Vue.component('row', FormRw)
Vue.component('rows', FormRws)
Vue.component('require-text', Require)
Vue.component('v-select', VueSelect)

Vue.config.productionTip = false

Validator.localize('pt_BR', translate)
Vue.use(uiv, { prefix: 'uiv', locale })
Vue.use(Scrollspy)
Vue.use(VueResource)
Vue.use(VueSession)
Vue.use(VueTheMask)
Vue.use(Tooltip);
Vue.use(VeeValidate);

window.globals = {
    API_SERVER: `${window.location.protocol}//${window.location.hostname}:3001`,
    SOCKET_SERVER: `${window.location.protocol}//${window.location.hostname}:3000`,
}
Vue.prototype.$globals = window.globals

new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
