import index from '@/components/eletronic-documents';
import Form from '@/components/eletronic-documents/Form.vue';
import Detail from '@/components/eletronic-documents/Detail.vue';
import CreateAmendment from '@/components/eletronic-documents/CreateAmendment.vue';

export default [
    {
        path: '/usuario/documentos-eletronicos',
        name: 'documentos-eletronicos',
        component: index,
        meta: { requiresAuth: true }
    },
    {
        path: '/usuario/documentos-eletronicos/add',
        name: 'documentos-eletronicos/add',
        component: Form,
        meta: { requiresAuth: true }
    },
    {
        path: '/usuario/documentos-eletronicos/edit/:id',
        name: 'documentos-eletronicos/edit',
        component: Form,
        meta: { requiresAuth: true }
    },
    {
        path: '/usuario/documentos-eletronicos/detalhe/:id',
        name: 'documentos-eletronicos/detalhe',
        component: Detail,
        meta: { requiresAuth: true }
    },
    {
        path: '/usuario/documentos-eletronicos/criar-emenda/:id',
        name: 'documentos-eletronicos/criar-emenda',
        component: CreateAmendment,
        meta: { requiresAuth: true }
    },
]

export const eletronicDocumentsTypesRoutes = require('./types').default
export const eletronicDocumentsStatusRoutes = require('./status').default