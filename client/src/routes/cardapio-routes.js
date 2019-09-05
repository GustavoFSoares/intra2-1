import index from '@/components/cardapio'
import Form from '@/components/cardapio/Form.vue'

export default [
    {
        path: '/cardapio',
        component: index,
        name: 'cardapio',
    },
    {
        path: '/usuario/cardapio/add',
        name: 'cardapio/add',
        component: Form,
        meta: { requiresAuth: true }
    },
]