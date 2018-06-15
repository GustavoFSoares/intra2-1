import index from '@/components/user-panel';

export default [
    {
        path: '/usuario',
        component: index,
        meta: { requiresAuth: true }
    },
]