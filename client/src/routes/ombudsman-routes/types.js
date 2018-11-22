import index from '@/components/ombudsman/types';
import Form from '@/components/ombudsman/types/Form.vue';

export default [
    {
        path: '/usuario/ouvidoria/tipos',
        name: 'ouvidoria/tipos',
        component: index,
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/usuario/ouvidoria/tipos/add',
        name: 'ouvidoria/tipos/add',
        component: Form,
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/usuario/ouvidoria/tipos/edit/:id',
        name: 'ouvidoria/tipos/edit',
        component: Form,
        meta: { requiresAuth: true, adminAuth: true }
    },
]