import index from '@/components/pops';
import PopsList from '@/components/pops/PopsList.vue';

export default [
    {
        path: '/pops',
        component: PopsList,
        name: 'pops/lista'
    },
    {
        path: '/usuario/pops',
        component: index,
        name: 'pops',
        meta: { requiresAuth: true }
    },
    
]