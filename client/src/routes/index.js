import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/components/Home.vue'
import Edit from '@/components/Edit.vue'
import Teste from '@/components/Teste.vue'
import NotFound from '@/components/NotFound.vue'

import EventosAdversos from '@/components/eventos-adversos';
import EventosAdversos_Relatar from '@/components/eventos-adversos/Relatar.vue';
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
    {
        path: '/teste',
        component: Teste
    },
    {
        path: '/eventos-adversos',
        component: EventosAdversos
    },
    {
        path: '/eventos-adversos/relatar',
        component: EventosAdversos_Relatar
    },
]

Vue.use(Router)
export default new Router({
    routes: routes,
    mode: 'history'
})

