import index from "@/components/anything";

export default [
    {
        path: '/usuario/qualquer-coisa',
        component: index,
        name: 'usurio/qualquer-coisa',
        meta: { requiresAuth: true }
    },
]