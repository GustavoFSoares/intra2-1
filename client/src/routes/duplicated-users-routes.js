import index from '@/components/duplicated-users';

export default [
    {
        path: '/usuario/usuarios-duplicados',
        name: "usuarios-duplicados",
        component: index,
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
]