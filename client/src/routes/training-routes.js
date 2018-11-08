import index from "@/components/training";
import Form from "@/components/training/Form.vue";
import AddParticipants from "@/components/training/AddParticipants.vue";

export default [
    {
        path: '/usuario/hora-homem-treinamento',
        component: index,
        name: 'hht', 
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu', 'recursos-humanos-hu'], levelAuth: 3 }
    },
    {
        path: '/usuario/hora-homem-treinamento/add',
        component: Form,
        name: 'hht/add',
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu', 'recursos-humanos-hu'], levelAuth: 3 }
    },
    {
        path: '/usuario/hora-homem-treinamento/edit/:id',
        component: Form,
        name: 'hht/edit',
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu', 'recursos-humanos-hu'], levelAuth: 3 }
    },
    {
        path: '/usuario/hora-homem-treinamento/lista-participantes/:id',
        component: AddParticipants,
        name: 'hht/lista-participantes',
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu', 'recursos-humanos-hu'], levelAuth: 3 }
    },
]