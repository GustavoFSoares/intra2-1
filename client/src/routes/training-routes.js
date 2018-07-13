import index from "@/components/training";
import Form from "@/components/training/Form.vue";

export default [
    {
        path: '/usuario/hora-homem-treinamento',
        component: index,
        name: 'hht', 
        meta: { requiresAuth: true }
    },
    {
        path: '/usuario/hora-homem-treinamento/add',
        component: Form,
        name: 'hht/add',
        meta: { requiresAuth: true }
    },
]