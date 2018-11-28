import index from '@/components/ombudsman/origins';
import Form from '@/components/ombudsman/origins/Form.vue';

export default [
    {
        path: '/usuario/ouvidoria/origem',
        name: 'ouvidoria/origem',
        component: index,
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/usuario/ouvidoria/origem/add',
        name: 'ouvidoria/origem/add',
        component: Form,
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/usuario/ouvidoria/origem/edit/:id',
        name: 'ouvidoria/origem/edit',
        component: Form,
        meta: { requiresAuth: true, adminAuth: true }
    },
]