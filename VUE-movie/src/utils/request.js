//封装axios请求
//引入axios
import axios from 'axios'
//消息提示组件
import {Message} from "element-ui"
//vue状态管理
import  store from "@/store"

import router from '@/router'
//全局发送post请求默认头部content-type类型,定义类型为json格式,字符编码utf-8
axios.defaults.headers.post['Content-Type'] = 'application/json;charset=UTF-8';

//创建axios实例进行全局配置
const  service = axios.create({
//  请求发送地址
//   baseURL:'http://localhost:3000',
  //请求过期时间
  timeout:5000
})

//请求发送之前的一个拦截器
service.interceptors.request.use(
  config=>{
    if(store.state.token){
      config.headers['x-Token'] = store.state.token//访问全局变量下的token值
    }
    return config
  },error=>{
    console.log(error);
    Promise.reject(error)
  }

)

//请求发送后数据返回的时候的拦截器
service.interceptors.response.use(
  response => {
    return response;
  },
  error => { //默认除了2XX之外的都是错误的，就会走这里
    if(error.response){
      switch(error.response.status){
        case 401:
          store.dispatch('UserLogout'); //可能是token过期，清除它
          router.replace({ //跳转到登录页面
            path: 'login'
          });
      }
    }
    return Promise.reject(error.response);
  }
);

export default  service
