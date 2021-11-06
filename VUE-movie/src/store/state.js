//定义全局的变量/数据
const state = {
  token:window.sessionStorage.getItem('token'),//通过sessionStorage存token,这个方法是获取到token的值

  username:''
}
export default state
