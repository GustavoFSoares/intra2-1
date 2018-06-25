import index from '@/components/modules'

const modulesRoutes = [
    {
        path: '/usuario/modulos',
        component: index,
        name: 'modules',
        meta: { requiresAuth: true, groupAuth: 'TECNOLOGIA DA INFORMACAO HU' }
    }
]
export default modulesRoutes