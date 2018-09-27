import Help from '@/components/incident-reporting/Help.vue';
import Reporting from '@/components/incident-reporting/Reporting.vue';
import index from '@/components/incident-reporting';
import Detail from '@/components/incident-reporting/Detail.vue';
import Edit from '@/components/incident-reporting/Edit.vue';
                
export default [
    {
        path: '/notificacao-de-incidentes',
        name: 'notificacao-de-incidentes/help',
        component: Help
    },
    {
        path: '/notificacao-de-incidentes/relatar',
        name: 'notificacao-de-incidentes/relatar',
        component: Reporting
    },
    {
        path: '/usuario/notificacao-de-incidentes',
        name: 'notificacao-de-incidentes',
        component: index,
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/usuario/notificacao-de-incidentes/detalhe/:id',
        name: 'notificacao-de-incidentes/detalhe',
        component: Detail,
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/usuario/notificacao-de-incidentes/edit/:id',
        name: 'notificacao-de-incidentes/edit',
        component: Edit,
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu', 'seger-hu'] }
    },
]