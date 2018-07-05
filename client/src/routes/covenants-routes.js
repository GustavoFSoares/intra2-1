import index from '@/components/covenants';
import Coventants from '@/components/covenants/Covenants.vue';
import Form from '@/components/covenants/Form.vue';

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
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/convenios/add',
        name: "convenios/add",
        component: Form,
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/convenios/edit/:id',
        name: "convenios/edit",
        component: Form,
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
]