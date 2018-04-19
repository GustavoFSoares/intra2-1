import index from '@/components/adverse-events';
import Report from '@/components/adverse-events/Report.vue';

const adverseEventsRoutes = [
    {
        path: '/eventos-adversos',
        component: index
    },
    {
        path: '/eventos-adversos/relatar',
        component: Report
    },
]
export default adverseEventsRoutes