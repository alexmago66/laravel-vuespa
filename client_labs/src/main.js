import Vue from 'vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'
import BootstrapVue from 'bootstrap-vue'

import App from './App'
import store from './store'

Vue.config.productionTip = false

Vue.use(VueRouter)
Vue.use(VueResource)
Vue.use(BootstrapVue)

Vue.component('app', App)

const routes = [
  {path: '/', component: require('./pages/LoginPage'), name: 'home'},
  {path: '/dashboard', component: require('./pages/DashboardPage'), name: 'dashboard', meta: {requiresAuth: true}},
  {path: '/chat', component: require('./pages/ChatPage'), name: 'chat', meta: {requiresAuth: true}}
]

const router = new VueRouter({
  mode: 'history',
  routes
})

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    const authUser = JSON.parse(window.localStorage.getItem('authUser'))
    if (authUser && authUser.access_token) {
      next()
    } else {
      next({name: 'home'})
    }
  }
  next()
})

new Vue({
  router,
  store,
  render: createEle => createEle(App)
}).$mount('#app')
