import index from '@/components/alerts';
import Form from '@/components/alerts/Form.vue';

const adverseEventsRoutes = [
    {
        path: '/alertas',
        component: index
    },
    {
        path: '/alertas/add',
        component: Form
    },
    {
        path: '/alertas/edit/:id',
        component: Form
    },
]
export default adverseEventsRoutes