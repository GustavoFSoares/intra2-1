import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/components/Home.vue'
import Teste from '@/components/Teste.vue'
import NotFound from '@/components/NotFound.vue'
import DontHavePermission from '@/components/DontHavePermission.vue'

import adverseEventsRoutes from './adverse-events-routes'
import alertsRoutes from './alerts-routes'
import covenantRoutes from './covenants-routes'
import loginRoutes from './login-routes'
import modulesRoutes from './modules-routes'
import ramalsRoutes from './ramals-routes'
import userPanelRoutes from './user-panel-routes'

import Access from "@/entity/Access";

const routes = [
    {
        path: `/`,
        component: Home
    },
    {
        path: '*',
        component: NotFound
    },
    {
        path: '/sem-permissao', 
        name: 'no-permission',
        component: DontHavePermission,
    }
]

const Routes = new Router({
    routes: routes,
    mode: 'history',
})
Routes.addRoutes(adverseEventsRoutes)
Routes.addRoutes(alertsRoutes)
Routes.addRoutes(covenantRoutes)
Routes.addRoutes(loginRoutes)
Routes.addRoutes(modulesRoutes)
Routes.addRoutes(ramalsRoutes)
Routes.addRoutes(userPanelRoutes)

Routes.beforeEach((to, from, next) => {
    const Session = (window.sessionStorage.getItem('vue-session-key') != '{}') ?
        JSON.parse(window.sessionStorage.getItem('vue-session-key')) : false
    
    if (to.meta.requiresAuth) {
        window.lastRouteAccess = to.path

        if (!Session) {
            next({ path: `/login` })
        } else {
            
            let access = new Access()
            
            access.id = Session.user.id
            access.path = to.path
            
            if (to.meta.groupAuth) {
                if (to.meta.groupAuth !== Session.user.group.groupId) {
                    access.permissions['group'] = false
                }
            }
            if (to.meta.levelAuth) {
                
                if (!(to.meta.levelAuth <= Session.user.level)) {
                    access.permissions['level'] = false
                }
            }
            if (to.meta.adminAuth) {
                if (to.meta.adminAuth !== Session.user.admin) {
                    access.permissions['admin'] = false
                }
            }
            
            if(access.isValid()) {
                next()
            } else {
                window.access = access
                next({ name: `no-permission` })
            }
            
        }
    } else {
        next()
    }
})

Vue.use(Router)
export default Routes