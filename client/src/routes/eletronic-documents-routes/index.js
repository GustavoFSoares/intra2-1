import index from '@/components/eletronic-documents';
import Form from '@/components/eletronic-documents/Form.vue';

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
        meta: { requiresAuth: true, adminAuth: true }
    },
]

export const eletronicDocumentsTypesRoutes = require('./types').default
export const eletronicDocumentsStatusRoutes = require('./status').default