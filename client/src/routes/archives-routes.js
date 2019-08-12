import index from '@/components/archives';
import ArchivesList from '@/components/archives/ArchivesList.vue';

export default [
    {
        path: '/archives',
        component: ArchivesList,
        name: 'archives/lista'
    },
    {
        path: '/usuario/archives',
        component: index,
        name: 'archives',
        meta: { requiresAuth: true }
    },
    
]