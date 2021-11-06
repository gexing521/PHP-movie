//开始进行状态管理  简单理解的话组件和组件之间是无法做到相互共享数据,必须用prop/emit来传值
/*我们可以通过vuex添加一些数据和共享方法
*/
import  Vuex from 'vuex'
import Vue from 'vue'
import state from './state'
import mutations from './mutations'
import actions from './actions'
//使vuex生效
Vue.use(Vuex)


const  store = new Vuex.Store({
  state,//全局变量
  mutations,//改变全局变量的方法
  actions,//全局方法
})


export  default  store
