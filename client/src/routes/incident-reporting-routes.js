import Help from '@/components/incident-reporting/Help.vue';
import Reporting from '@/components/incident-reporting/Reporting.vue';
                
export default [
    {
        path: '/notificacao-de-incidentes/',
        name: 'notificacao-de-incidentes',
        component: Help
    },
    {
        path: '/notificacao-de-incidentes/relatar',
        name: 'notificacao-de-incidentes/relatar',
        component: Reporting
    },
]