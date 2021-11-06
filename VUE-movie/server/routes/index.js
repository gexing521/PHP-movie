const  Router = require('koa-router');
const  subRouter = new Router();
const UserController = require('../controller/user')
//服务器判断token是否合法
const checkToken = require('../token/checkToken')
subRouter.post('/register',UserController.register)
subRouter.post('/login',UserController.login)



module.exports = subRouter
