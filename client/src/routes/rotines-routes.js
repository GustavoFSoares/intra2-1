import index from '@/components/rotines';
import Logs from '@/components/rotines/Logs.vue';

const ramalsRoutes = [
    {
        path: '/usuario/rotinas',
        component: index,
        name: 'rotinas',
        meta: { requiresAuth: true, group: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/rotinas/logs/:id',
        component: Logs,
        name: 'rotinas/logs',
        meta: { requiresAuth: true, group: ['tecnologia-da-informacao-hu'] }
    },
]
export default ramalsRoutes