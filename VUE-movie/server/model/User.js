const mongoose = require('mongoose');
//创建数据库的架构
//这里面指定集合里面的字段,字段类型
const UserScheam = new mongoose.Schema({
  //常用数据类型
  //string
  //number
  //date
  //boolean
  //objectID
  //ARRAY
  username:String,
  password:String,
  token:String,
  create_time:String
});
  UserScheam.statics = {
//自定义方法
getUserByName:function (username) {
  return new Promise((resolve,reject)=>{
    User.findOne({username},(err,doc)=>{
      if(err){
        reject(err);
      }else {
        resolve(doc);
      }
    })
  })
}

  }
//第一个参数是模型的名字,集合的名字   第二个参数是集合实用的架构
const User=mongoose.model('User',UserScheam);
module.exports=User;
/*
* 所有操作都是在User模型上
* 例如查询User.find()/findOne
* 修改 User.update()
* 删除User.delete
* 添加 let newUser = new User()   newUser.save
* */
