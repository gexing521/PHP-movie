
<template>

  <ul >

    <el-header>
      <meta name="referrer" content="never">
    </el-header>

    <div class="tableTitle" style="margin-top:1px;margin-left: 27%;"><span class="midText">我劝你看一看</span></div>
    <div style="margin-top:30px;margin-left: 10%">
      <li  v-for="movie in this.recList" :key="movie[0]">
        <div STYLE="float: left;margin-left: 50px">
          <div style="width: 150px;height: 500px">
            <img :src=movie[2] style="height: 200px ;width: 150px">
            <br>
            <br>
            <p style="height:10px;width:150px;font-size: 20px">{{ movie[1] }}</p>
            <br>
            <p style="font-size: 20px;margin-top: 13px">{{ movie[3] }}</p>
            <br>

            <div v-if="isReloadData" style=" display: inline-block ;width: 25px;height: 20px"
                 v-for="(num,index) in 5" :key="index" @click="handle(movie[0],num)">
              <img  style="float:left;width: 20px;height: 20px" :src='movie[3]/2>=num?ling:bu' alt="">

            </div>
            <br>
          </div>
        </div>

      </li>
    </div>





    <div class="tableTitle" style="margin-top:400px;"><span class="midText"></span></div>
    <div style="margin-top:50px;margin-left: 10%">
    <li  v-for="movie in this.allList" :key="movie[0]">
      <div STYLE="float: left;margin-left: 50px">
        <div style="width: 150px;height: 400px">
      <img :src=movie[2] style="height: 200px ;width: 150px">
          <br>
          <br>
      <p style="height:10px;width:150px;font-size: 20px">{{ movie[1] }}</p>
          <br>
      <p style="font-size: 20px">{{ movie[3] }}</p>
      <br>

            <div v-if="isReloadData" style=" display: inline-block ;width: 25px;height: 20px"
                 v-for="(num,index) in 5" :key="index" @click="handle(movie[0],num)">
              <img  style="float:left;width: 20px;height: 20px" :src='movie[3]/2>=num?ling:bu' alt="">

            </div>
      <br>
        </div>
      </div>

    </li>
    </div>
  </ul>


</template>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
import BeiNav from '@/components/BeiNav'
import axios from "axios";
import request from '@/utils/request'
import img from '../img/1.png'
import imgB from '../img/0.png'
export default {
  name: "Index",
  components:{
    BeiNav
  },
  data:function () {
    return  {
      token: '',
      allList: [],
      recList: [],
      bu:imgB,
      ling:img,
      isReloadData: true
    }
  },
  props:{
    rating:Number
  },
  methods: {
    handle(id,val){
      var Token=window.sessionStorage.getItem("token");
      var user=window.sessionStorage.getItem("username");
      for (var i=0;i<this.allList.length;i++)
      {
          if(this.allList[i][0]==id){
            console.log(this.allList[i][3])
            this.allList[i][3]=val*2;
            console.log(this.allList[i][3])
            break;
          }
      }
      request({
        url: '/movie/Movie/insert/index.php',
        method: 'post',
        data: {token:Token,username:user,m_id:id,star:val*2}
      }).then(({data}) => {
        if(data.code==200){
          this.$message.info(data.message)
          this.getRecList();
          console.log(data.data)
        }else if(data.code==40001){
          this.$message.info(data.message)
          this.$router.push('/login');
        }else{
          this.$message.info(data.message)
        }

      }).catch(err=>{
        console.log(err)
      })
      this.reload()

    },
    reload () {
      this.isReloadData = false;
      this.$nextTick(() => {
        this.isReloadData = true;
      })
    },
    getList() {      //这个方法输给users填充数据的，但是没法直接初始化时就调用
      this.allList=[];
      var Token=window.sessionStorage.getItem("token");
      var user=window.sessionStorage.getItem("username");
      request({
        url: '/movie/Movie/allList/index.php',
        method: 'post',
        data: {token:Token,username:user}
      }).then(({data}) => {
        if(data.code==200){
          this.$message.info(data.message)
          this.allList=data.data;
        }else if(data.code==40001){
          this.$message.info(data.message)
          this.$router.push('/login');
        }else{
          this.$message.info(data.message)
        }

      }).catch(err=>{
        console.log(err)
      })
    },
    getRecList() {      //这个方法输给users填充数据的，但是没法直接初始化时就调用
      this.recList=[];
      var user=window.sessionStorage.getItem("username");
      request({
        url: '/movie/Movie/Reco/index.php',
        method: 'post',
        data: {username:user}
      }).then(({data}) => {
        if(data.code==200){
          this.recList=data.data;
        }else if(data.code==40001){
          this.$router.push('/login');
        }

      }).catch(err=>{
        console.log(err)
      })
    }
  },
  mounted () { //这个属性就可以，在里面声明初始化时要调用的方法即可
    // we can implement any method here like
    this.getList();
    this.copy_allList=this.allList;

  }

  }

</script>

<style scoped>
.Rating-gray {
  margin-right: 1.066667vw;
  color: #ffbe00;
  display: inline-block;
}
.tableTitle {
  position: relative;
  margin: 0 auto;
  width: 600px;
  height: 1px;
  background-color: #d4d4d4;
  text-align: center;
  font-size: 16px;
  color: rgba(101, 101, 101, 1);
}
.midText {
  position: absolute;
  left: 50%;
  background-color: #ffffff;
  padding: 0 15px;
  transform: translateX(-50%) translateY(-50%);
}

</style>
