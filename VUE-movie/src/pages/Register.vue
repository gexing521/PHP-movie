<template>
  <div>
    <el-row>
      <el-col :span="24">

        <el-menu router @select="handleSelect" :default-active="activeIndex" mode="horizontal"
                 background-color="#545c64" text-color="#fff" active-text-color="#ffd04b">
          <el-menu-item index="/login">登录</el-menu-item>
          <el-menu-item index="/register">注册</el-menu-item>
        </el-menu>
      </el-col>
    </el-row>
    <el-main class="bg-dark">
      <el-row>
        <el-col :span="12" :offset="7">
          <el-form label-width="80px" ref="regForm" :model="regForm" :rules='rules'>
            <el-form-item label="用户名" prop="username">
              <el-input type="text" v-model="regForm.username"></el-input>
            </el-form-item>

            <el-form-item label="密码" prop='password'>
              <el-input type="password" v-model="regForm.password"></el-input>
            </el-form-item>

            <el-form-item label="确认密码" prop='checkpassword'>
              <el-input type="password" v-model="regForm.checkpassword"></el-input>
            </el-form-item>

            <el-form-item>
              <el-button type="success" @click="submitForm('regForm')">注册</el-button>
              <el-button type="danger">重置</el-button>
            </el-form-item>

          </el-form>
        </el-col>
      </el-row>
    </el-main>


  </div>

</template>

<script>
  import request from '../utils/request'

  export default {
    name: "Register",
    data() {
      let validatorPass = (rule, value, callback) => {
        let reg = /(?!^[0-9]+$)(?!^[A-z]+$)(?!^[^A-z0-9]+$)^[^\s\u4e00-\u9fa5]{6,16}$/;

        if (!reg.test(value)) {
          callback(new Error('密码必须是6-16位数组字母的组合'));
        } else {
          callback();
        }


      };
      let validatorPass2 = (rule, value, callback) => {
        if (value != this.regForm.password) {
          callback(new Error('两次密码不一致'));
        } else {
          callback();
        }
      }
      return {
        activeIndex: '/register',
        regForm: {
          username: '',
          password: '',
          checkpassword: ''
        },
        rules: {
          username: [
            {required: true, message: '请输入用户名称', trigger: 'blur'},
            {min: 6, max: 15, message: '长度在 6 到 15 个字符', trigger: 'blur'}
          ],
          password: [
            {required: true, message: '请输入密码', trigger: 'blur'},
            {validator: validatorPass, trigger: 'blur'}

          ],
          checkpassword: [
            {required: true, message: '请输入密码', trigger: 'blur'},
            {validator: validatorPass2, trigger: 'blur'}
          ]
        }
      }
    },
    methods: {
      handleSelect: function () {

      },
      //提交数据
      submitForm: function (forName) {
        this.$refs[forName].validate((valid) => {
          if (valid) {
            //  验证成功发送请求
            request({
              url: "/movie/User/register/index.php",
              method: 'post',
              data: this.regForm
            }).then(({data}) => {
              let success = data.success;
              let message = data.message;
              if (success) {
                this.$router.push('/login');
                this.$message.success(message);
              } else {
                //失败后提示
                // alert('用户名重复.请重新注册');
                this.$message.error(message);
              }
            }).catch(err => {
              console.log(err);
            })
          } else {
            console.log('验证失败');
            return false;
          }
        })
      }
    }
  }
</script>

<style scoped>

</style>
