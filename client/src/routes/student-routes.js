import index from "@/components/student";
import Form from "@/components/student/Form.vue";

export default [
    {
        path: '/usuario/universitarios',
        component: index,
        name: 'universitarios',
        meta: { requiresAuth: true }
    },
    {
        path: '/usuario/universitarios/add',
        component: Form,
        name: 'universitarios/add',
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu', 'recursos-humanos-hu'] }
    },
    {
        path: '/usuario/universitarios/edit/:id',
        component: Form,
        name: 'universitarios/edit',
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu', 'recursos-humanos-hu'] }
    },
]