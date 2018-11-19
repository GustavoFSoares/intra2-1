import index from '@/components/ombudsman';
import Form from '@/components/ombudsman/Form.vue';

export default [
    {
        path: '/usuario/ouvidoria',
        name: 'ouvidoria',
        component: index,
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/usuario/ouvidoria/add',
        name: 'ouvidoria/add',
        component: Form,
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/usuario/ouvidoria/edit/:id',
        name: 'ouvidoria/edit',
        component: Form,
        meta: { requiresAuth: true, adminAuth: true }
    },
]