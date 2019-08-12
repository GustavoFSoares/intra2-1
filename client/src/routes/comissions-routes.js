import index from '@/components/comissions';
import ComissionsList from '@/components/comissions/ComissionsList.vue';

export default [
    {
        path: '/comissions',
        component: ComissionsList,
        name: 'comissions/lista'
    },
    {
        path: '/usuario/comissions',
        component: index,
        name: 'comissions',
        meta: { requiresAuth: true }
    },
    
]