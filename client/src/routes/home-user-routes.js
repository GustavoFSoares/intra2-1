import index from "@/components/home-user";

export default [
    {
        path: '/usuario',
        component: index,
        name: 'usuarios',
        meta: { requiresAuth: true }
    },
]