// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import ElementUI from 'element-ui'
//引入element-ui样式
import 'element-ui/lib/theme-chalk/index.css'

//引入全局main.scss
import '@/style/main.scss'
Vue.config.productionTip = true
import store from '@/store'
import axios from 'axios'
Vue.prototype.$axios = axios

//使用element-ui作为们的前端框架
Vue.use(ElementUI,{

})
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'

})
