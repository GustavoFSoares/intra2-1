import index from '@/components/covenants';
import Coventants from '@/components/covenants/Covenants.vue';
import Form from '@/components/covenants/Form.vue';

let groups = ['tecnologia-da-informacao-hu', 'faturamento-hu']

export default [
    {
        path: '/convenios',
        name: "convenios/convenios",
        component: Coventants,
        meta: { }
    },
    {
        path: '/usuario/convenios',
        name: "convenios",
        component: index,
        meta: { requiresAuth: true, groupAuth: groups }
    },
    {
        path: '/usuario/convenios/add',
        name: "convenios/add",
        component: Form,
        meta: { requiresAuth: true, groupAuth: groups }
    },
    {
        path: '/usuario/convenios/edit/:id',
        name: "convenios/edit",
        component: Form,
        meta: { requiresAuth: true, groupAuth: groups }
    },
]