window.onload=function asd() {
  var can = document.getElementById("canvas");
  //设置绘图环境
  var cxt = can.getContext("2d");
  //获取浏览器窗口的宽高
  var w = can.width = window.innerWidth;
  var h = can.height = window.innerHeight;
  //让画布的宽高跟随浏览器窗口的变化而变化
  window.onresize = function () {
    w = can.width = window.innerWidth;
    h = can.height = window.innerHeight;
  };
  //设置画笔颜色
  cxt.fillStyle = "aqua";

  //面向对象
  var drops = [];
  // 创建雨滴对象
  function Drop() { }
  //添加对象方法
  Drop.prototype = {
    init: function () { //初始化方法 设置每个雨滴的初始化属性
      //设置坐标
      this.x = random(0, w);
      this.y = 0;
      //y方向的速度值
      this.vy = random(4, 5);
      //雨滴下落的最大高度
      this.l = random(0.8 * h, 0.9 * h);
      //波纹的初始半径
      this.r = 1;
      this.vr = 1; //半径增大的速度
      //判断雨滴消失的透明度
      this.a = 1; // =>0
      this.va = 0.96; //透明度的变化系数
    },
    draw: function () { //绘制图形
      if (this.y > this.l) { //雨滴下落到了指定位置 开始绘制圆形
        cxt.beginPath(); //先开始路径
        cxt.arc(this.x, this.y, this.r, 0, Math.PI * 2, false);
        cxt.strokeStyle = "rgba(0,255,255," + this.a + ")";
        cxt.stroke();
      } else { //绘制下落的雨滴
        cxt.fillStyle = "rgb(0,255,255)";
        cxt.fillRect(this.x, this.y, 2, 10);
      }

      this.update();
    },
    update: function () { //更新坐标位置
      if (this.y < this.l) {
        this.y += this.vy
      } else { //雨滴下落到了指定位置 开始绘制波纹
        if (this.a > 0.03) {
          this.r += this.vr;
          if (this.r > 50) {
            this.a *= this.va;
          }
        } else {
          //重新初始化
          this.init()
        }

      }
    }
  };
  //新建一个雨滴实例化对象
  //var drop = new Drop();
  //drop.init();// 初始化
  //drop.draw();//绘制
  for (var i = 0; i < 30; i++) {
    setTimeout(function () {
      var drop = new Drop();
      drop.init();
      drops.push(drop);
    }, i * 300)

  }
  //console.log(drops)
  function move() {
    //cxt.clearRect(0,0,w,h);
    //先复制透明层再绘制雨滴 雨滴就把先绘制的透明层覆盖 下一次绘制透明层
    //就会把之前绘制的雨滴覆盖 若干的透明层叠加就会越来越不透明
    cxt.fillStyle = "rgba(0,0,0,0.1)";
    cxt.fillRect(0, 0, w, h);
    for (var k = 0; k < drops.length; k++) {
      drops[k].draw();
    }
    requestAnimationFrame(move);
  }
  move();
  //生成随机数的方法
  function random(min, max) {
    return Math.random() * (max - min) + min; //min - max之间的随机数
  }

}
export {
  asd
}
