import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/components/Home.vue'
import Teste from '@/components/Teste.vue'
import NotFound from '@/components/NotFound.vue'

import adverseEventsRoutes from './adverse-events-routes'
import ramalsRoutes from './ramals-routes'
import alertsRoutes from './alerts-routes'

const routes = [
    {
        path: `/`,
        component: Home
    },
    {
        path: '*',
        component: NotFound
    },
]

const Routes = new Router({
    routes: routes,
    mode: 'history',
})
Routes.addRoutes(adverseEventsRoutes)
Routes.addRoutes(ramalsRoutes)
Routes.addRoutes(alertsRoutes)

Vue.use(Router)
export default Routes