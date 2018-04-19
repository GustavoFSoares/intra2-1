import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/components/Home.vue'
import Edit from '@/components/Edit.vue'
import Teste from '@/components/Teste.vue'
import NotFound from '@/components/NotFound.vue'

import adverseEventsRoutes from './adverse-events-routes'
const routes = [
    {
        path: `/`,
        component: Home
    },
    {
        path: '/edit/:id',
        component: Edit
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

Vue.use(Router)
export default Routes