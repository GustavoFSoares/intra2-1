import index from "@/components/admin-manager";

export default [
    {
        path: '/usuario/gerenciador-de-administradores',
        component: index,
        name: 'gerenciador-de-administradores',
        meta: { requiresAuth: true }
    },
]