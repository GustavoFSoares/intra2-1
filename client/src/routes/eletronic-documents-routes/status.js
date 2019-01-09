import index from '@/components/eletronic-documents/status';
import Form from '@/components/eletronic-documents/status/Form.vue';

export default [
    {
        path: '/usuario/documentos-eletronicos/status',
        name: 'documentos-eletronicos/status',
        component: index,
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/documentos-eletronicos/status/add',
        name: 'documentos-eletronicos/status/add',
        component: Form,
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/documentos-eletronicos/status/edit/:id',
        name: 'documentos-eletronicos/status/edit',
        component: Form,
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
]