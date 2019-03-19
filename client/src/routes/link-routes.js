import index from '@/components/link';
import Form from '@/components/link/Form.vue';

export default [
    {
        path: '/usuario/link',
        component: index,
        name: 'link',
        meta: { requiresAuth: true, group: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/link/add',
        component: Form,
        name: 'link/add',
        meta: { requiresAuth: true, group: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/link/edit/:id',
        component: Form,
        name: 'link/edit',
        meta: { requiresAuth: true, group: ['tecnologia-da-informacao-hu'] }
    },
]