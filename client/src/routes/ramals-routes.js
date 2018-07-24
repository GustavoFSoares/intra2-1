import index from '@/components/ramals';
import ListRamals from '@/components/ramals/ListRamals.vue';
import Form from '@/components/ramals/Form.vue';

const ramalsRoutes = [
    {
        path: '/ramais',
        component: ListRamals,
        name: 'ramais/lista'
    },
    {
        path: '/usuario/ramais',
        component: index,
        name: 'ramais',
        meta: { requiresAuth: true, group: ['recepcoes-hu', 'tecnologia-da-informacao-hu'], adminAuth: true }
    },
    {
        path: '/usuario/ramais/add',
        component: Form,
        name: 'ramais/add',
        meta: { requiresAuth: true, group: ['recepcoes-hu', 'tecnologia-da-informacao-hu'], adminAuth: true }
    },
    {
        path: '/usuario/ramais/edit/:id',
        component: Form,
        name: 'ramais/edit',
        meta: { requiresAuth: true, group: ['recepcoes-hu', 'tecnologia-da-informacao-hu'], adminAuth: true }
    },
]
export default ramalsRoutes