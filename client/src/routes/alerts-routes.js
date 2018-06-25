import index from '@/components/alerts';
import Form from '@/components/alerts/Form.vue';

export default [
    {
        path: '/alertas',
        name: "alertas",
        component: index,
        meta: { requiresAuth: true, groupAuth: 'TECNOLOGIA DA INFORMACAO HU' }
    },
    {
        path: '/alertas/add',
        component: Form,
        meta: { requiresAuth: true, groupAuth: 'TECNOLOGIA DA INFORMACAO HU' }
    },
    {
        path: '/alertas/edit/:id',
        component: Form,
        meta: { requiresAuth: true, groupAuth: 'TECNOLOGIA DA INFORMACAO HU' }
    },
]