import index from '@/components/covernant';
import Administrative from '@/components/covernant/Administrative.vue';

export default [
    {
        path: '/usuario/convenios',
        name: "covernant",
        component: index,
        meta: { requiresAuth: true, groupAuth: 'tecnologia-da-informacao-hu' }
    },
    {
        path: '/usuario/convenios/add',
        name: "covernant/add",
        component: Administrative,
        meta: { requiresAuth: true, groupAuth: 'tecnologia-da-informacao-hu', levelAuth: 2 }
    },
    {
        path: '/usuario/convenios/edit/:id',
        name: "covernant/edit",
        component: Administrative,
        meta: { requiresAuth: true, groupAuth: 'tecnologia-da-informacao-hu', levelAuth: 2 }
    },
]