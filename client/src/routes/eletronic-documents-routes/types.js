import index from '@/components/eletronic-documents/type';
import Form from '@/components/eletronic-documents/type/Form.vue';

export default [
    {
        path: '/usuario/documentos-eletronicos/tipo',
        name: 'documentos-eletronicos/tipo',
        component: index,
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/documentos-eletronicos/tipo/add',
        name: 'documentos-eletronicos/tipo/add',
        component: Form,
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
    {
        path: '/usuario/documentos-eletronicos/tipo/edit/:id',
        name: 'documentos-eletronicos/tipo/edit',
        component: Form,
        meta: { requiresAuth: true, groupAuth: ['tecnologia-da-informacao-hu'] }
    },
]