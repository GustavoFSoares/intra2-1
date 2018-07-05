import index from '@/components/modules'
import Form from '@/components/modules/Form.vue'
import Permissions from '@/components/modules/Permissions.vue'

const modulesRoutes = [
    {
        path: '/usuario/modulos',
        component: index,
        name: 'modulos',
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/modulos/add',
        component: Form,
        name: 'modulos/add',
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/modulos/edit/:id',
        component: Form,
        name: 'modulos/edit',
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },    
    {
        path: '/usuario/modulos/permissoes',
        component: Permissions,
        name: 'modulos/permissoes',
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
    
]
export default modulesRoutes