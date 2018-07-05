import index from '@/components/alerts';
import Form from '@/components/alerts/Form.vue';

export default [
    {
        path: '/usuario/alertas',
        name: "alertas",
        component: index,
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/alertas/add',
        name: "alertas/add",
        component: Form,
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/alertas/edit/:id',
        name: "alertas/edit",
        component: Form,
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
]