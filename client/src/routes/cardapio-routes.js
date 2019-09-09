import index from '@/components/cardapio'
import Form from '@/components/cardapio/Form.vue'
import List from '@/components/cardapio/List.vue'

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
    {
        path: '/usuario/cardapio/edit/:id',
        name: 'cardapio/edit',
        component: Form,
        meta: { requiresAuth: true }
    },
    {
        path: '/usuario/cardapio/lista',
        name: 'cardapio/lista',
        component: List,
        meta: { requiresAuth: true }
    }
]