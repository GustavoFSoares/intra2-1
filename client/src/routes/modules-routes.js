import index from '@/components/modules'

const modulesRoutes = [
    {
        path: '/usuario/modulos',
        component: index,
        name: 'modules',
        meta: { requiresAuth: true, groupAuth: 'tecnologia-da-informacao-hu' }
    }
]
export default modulesRoutes