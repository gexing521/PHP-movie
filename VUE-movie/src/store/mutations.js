//全局改变state方法

const  mutations={
LOGIN:(state,data)=>{

  state.token = data;
  window.sessionStorage.setItem('token',data)
},
  USERNAME:(state,data)=>{
  state.username = data;
  window.sessionStorage.setItem('username',data)
  },
  LOGOUT:(state,data)=>{
  state.token=null;
  window.sessionStorage.removeItem('token');
  }
}
export default  mutations

