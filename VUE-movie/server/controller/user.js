const db = require('../model/db');
//引入user集合
const User = require('../model/User');

//引入sha1加密
const sha1 = require('sha1');
//引入格式化日期的moment
const moment = require('moment');
//引入创建token方法
const createToken = require('../token/createToken')
//处理post请求/register的处理函数  这个处理函数需要将用户名密码写入数据库  所以在数据库中创建User集合
//通过./controller/user.js这个文件对数据库进行增删改查
const register = async ctx => {
//  1.判断数据库中是否有同名的用户名,如果存在,不许注册
//  2.需要验证数据的合法性  --validator验证,也可以不验证,保险的话,前端验证,后端在验证一次
//  3.注册的时候都需要对事件进行格式化
//  4.将注册用户信息保存在数据库中
//  5.生成token,将成功的注册信息及token放回前端
  let username = ctx.request.body.username;
  let password = ctx.request.body.password;
  // console.log(username)
  let doc = await User.getUserByName(username);
  console.log(doc);
  if (doc) {
    ctx.status = 200;
    ctx.body = {
      success: false,
      message: '用户名不允许重复'
    }
  } else {
    //  说明数据库没有重复可以注册  一般为了安全,还要对username/password进行二次验证
    //  可以利用node里面的validator模块进行二次验证
    password = sha1(password);
    console.log(password);
    let date = new Date();
    let create_time = moment(date).format('YYYY-MM-DD  HH:mm:ss');//格式化当前时间
    // 生成token
    let token = createToken(username);
    let newUser = new User({
      username,
      password,
      token,
      create_time
    })
    let userInfo = await new Promise((resolve, reject) => {
      newUser.save((err, doc) => {
        if (err) {
          reject(err)
        }
        resolve(doc)
      })
    })

    ctx.status = 200;
    ctx.body = {
      success: true,
      message: '注册成功',
      data: userInfo//有些网站是注册后直接登录,所以这里把用户信息也返回了,就是为了兼容哪些网站
    }

  }

}
const login=async ctx=>{
  let username = ctx.request.body.username;
  let password = ctx.request.body.password;
  let doc = await User.getUserByName(username);
  if(doc){
    if(doc.password == sha1(password)){
      let token = createToken(username);
      doc.token = token;
      await new  Promise((resolve,reject)=>{
        doc.save((err,doc)=>{
          if(err){
            reject(err);
          }else{
            resolve()
          }
        })
      })
      ctx.status=200;
      ctx.body = {
        success:true,
        message:'登陆成功',
        token:token,
        username:username
      }
    }else {
      ctx.status = 200;
      ctx.body={
        success:false,
        message:'密码错误....'
      }
    }
  }else{
    ctx.status=200;
    ctx.body={
      success:false,
      message:'用户名不存在.....'
    }
  }

}


module.exports = {
  register,
  login
}
