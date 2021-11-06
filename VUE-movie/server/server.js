const koa = require('koa');
const Router = require('koa-router');
const bodyParser = require('koa-bodyparser');

const app = new koa();
const router = new Router();

const subRouter = require('./routes/index')
router.use('/api',subRouter.routes(),subRouter.allowedMethods());

app.use(bodyParser());

//接收一切请求
app.use(router.routes(),router.allowedMethods());

app.listen(3000,function () {
  console.log('running.................');
})
