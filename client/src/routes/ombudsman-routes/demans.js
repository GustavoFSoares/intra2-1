import index from '@/components/ombudsman/demands';
import Form from '@/components/ombudsman/demands/Form.vue';

export default [
    {
        path: '/usuario/ouvidoria/demandas',
        name: 'ouvidoria/demandas',
        component: index,
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/usuario/ouvidoria/demandas/add',
        name: 'ouvidoria/demandas/add',
        component: Form,
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/usuario/ouvidoria/demandas/edit/:id',
        name: 'ouvidoria/dememandas/edit',
        component: Form,
        meta: { requiresAuth: true, adminAuth: true }
    },
]