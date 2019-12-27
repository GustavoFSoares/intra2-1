import index from '@/components/sectors';
import Form from '@/components/sectors/Form.vue';

export default [
    {
        path: '/usuario/setores',
        component: index,
        name: 'sector',
        meta: { requiresAuth: true, group: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/setores/add',
        component: Form,
        name: 'sector/add',
        meta: { requiresAuth: true, group: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/setores/edit/:id',
        component: Form,
        name: 'sector/edit',
        meta: { requiresAuth: true, group: ['tecnologia-da-informacao-hu'] }
    },
]