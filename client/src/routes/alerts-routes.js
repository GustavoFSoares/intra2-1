import index from '@/components/alerts';
import Form from '@/components/alerts/Form.vue';

export default [
    {
        path: '/usuario/alertas',
        name: "alertas",
        component: index,
        meta: { requiresAuth: true, groupAuth: 'tecnologia-da-informacao-hu' }
    },
    {
        path: '/alertas/add',
        component: Form,
        meta: { requiresAuth: true, groupAuth: 'tecnologia-da-informacao-hu', levelAuth: 2 }
    },
    {
        path: '/alertas/edit/:id',
        component: Form,
        meta: { requiresAuth: true, groupAuth: 'tecnologia-da-informacao-hu', levelAuth: 2 }
    },
]