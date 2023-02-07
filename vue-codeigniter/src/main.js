// import { createApp } from 'vue'
// import App from './App.vue'

// import './assets/main.css'

// createApp(App).mount('#app')
import Vue from 'vue'
import App from './App.vue'

Vue.config.productionTip = false

//import vue router
import VueRouter from 'vue-router'

Vue.use(VueRouter);

//import component
import PostIndex from './components/posts/Index.vue'
import PostCreate from './components/posts/Create.vue'
import PostEdit from './components/posts/Edit.vue'

const router = new VueRouter({
  routes: [{
      path: '/',
      name: 'posts',
      component: PostIndex
    },
    {
      path: '/create',
      name: '/create',
      component: PostCreate
    },
    {
      path: '/edit/:id',
      name: 'edit',
      component: PostEdit
    }
  ],
  mode: 'history'
})

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
