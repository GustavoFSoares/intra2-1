import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/components/Home.vue'
import Teste from '@/components/Teste.vue'
import NotFound from '@/components/NotFound.vue'
import DontHavePermission from '@/components/DontHavePermission.vue'

import adminManagerRoutes from './admin-manager-routes'
import adverseEventsRoutes from './adverse-events-routes'
import alertsRoutes from './alerts-routes'
import collaboratorsRoutes from './collaborators-routes'
import covenantRoutes from './covenants-routes'
import homeUserRoutes from './home-user-routes'
import incidentReportingRoutes from './incident-reporting-routes'
import loginRoutes from './login-routes'
import modulesRoutes from './modules-routes'
import ramalsRoutes from './ramals-routes'
import trainingRoutes from './training-routes'
import userRoutes from './user-routes'

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
        path: '/teste',
        component: Teste
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
Routes.addRoutes(adminManagerRoutes)
Routes.addRoutes(adverseEventsRoutes)
Routes.addRoutes(alertsRoutes)
Routes.addRoutes(collaboratorsRoutes)
Routes.addRoutes(covenantRoutes)
Routes.addRoutes(homeUserRoutes)
Routes.addRoutes(incidentReportingRoutes)
Routes.addRoutes(loginRoutes)
Routes.addRoutes(modulesRoutes)
Routes.addRoutes(ramalsRoutes)
Routes.addRoutes(trainingRoutes)
Routes.addRoutes(userRoutes)

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
                let ok = false
                to.meta.groupAuth.forEach(group => {
                    if (ok != true) {
                        if (group == Session.user.group.groupId) {
                            ok = true
                            access.permissions = access.permissions.splice('group', 0)
                        } else {
                            access.permissions['group'] = false
                        }
                    }
                })
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