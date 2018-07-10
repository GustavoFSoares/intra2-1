import index from "@/components/user";
import Panel from '@/components/user/Panel.vue';
import Form from "@/components/user/Form.vue";

export default [
    {
        path: '/usuario',
        component: Panel,
        name: 'usuarios',
        meta: { requiresAuth: true }
    },
    {
        path: '/usuario/gerenciador',
        component: index,
        name: 'usuarios/gerenciador', 
        meta: { requiresAuth: true }
    },
    {
        path: '/usuario/gerenciador/edit/:id',
        component: Form,
        name: 'usuarios/edit',
        meta: { requiresAuth: true, adminAuth: true }
    },
]