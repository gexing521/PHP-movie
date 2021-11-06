import Vue from 'vue'
import Router from 'vue-router'

import store from '@/store'


//路由懒加载

const Login = resolve=>{
  require.ensure(['pages/Login.vue'],()=>{
    resolve(require('pages/Login.vue'));
  })
}
const  Home = resolve=>{
  require.ensure(['pages/Home.vue'],()=>{
    resolve(require('pages/Home.vue'));
  })
}
const  Register = resolve=>{
  require.ensure(['pages/Register.vue'],()=>{
    resolve(require('pages/Register.vue'));
  })
}
const  Error = resolve=>{
  require.ensure(['pages/404.vue'],()=>{
    resolve(require('pages/404.vue'));
  })
}
const Index = resolve=>{
  require.ensure(['pages/Index.vue'],()=>{
    resolve(require('pages/Index.vue'));
  })
}
const test = resolve=>{
  require.ensure(['pages/test.vue'],()=>{
    resolve(require('pages/test.vue'));
  })
}
Vue.use(Router)
const router = new Router({
  //去除#号
  mode:'history',
  routes: [
    {
      path: '/',
      component: Home,
      //  在需要权限的页面中添加一个requireAuth字段,写在meta里面
      meta:{
        requiresAuth:true

      }
    },
    {
      path:'/login',
      component:Login
    },
    {
      path:'/index',
      component:Index
    },
    {
      path:'/register',
      component:Register
    },
    {
      path:'/test',
      component:test
    },
    {
      path:'/*',
      component:Error
    }
  ]
})

//路由跳转前都会执行
router.beforeEach((to,from,next)=>{
//  获取token
  let token = store.state.token;
  if(to.meta.requiresAuth){
    if(token){
      next();
    }else {
      //token不存在,让他跳转登录界面
      next({
        path:'/login'
      })
    }
  }else{
    // 不需要权限继续往下走
    next();
  }
})

export default router
