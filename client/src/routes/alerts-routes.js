import index from '@/components/alerts';
import Form from '@/components/alerts/Form.vue';

const Rule = { requiresAuth: true, groupAuth: 'ti' }
export default [
    {
        path: '/alertas',
        component: index,
        meta: Rule
    },
    {
        path: '/alertas/add',
        component: Form,
        meta: Rule
    },
    {
        path: '/alertas/edit/:id',
        component: Form,
        meta: Rule
    },
]