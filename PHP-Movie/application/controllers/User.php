<?php
error_reporting(0);
require("SqlTool/SqlCon.php");
class UserController extends Yaf_Controller_Abstract{
    public function setToken($username){
        $str = md5(uniqid(md5(microtime(true)),true));
        $token = sha1($str.$username);
        return $token;
    }

    public function loginAction(){
        $this->sqltool = new Sqltool();
        $request = @file_get_contents('php://input');
        $request = json_decode($request,TRUE);
        $username = $request['username'];
        $password = $request['password'];
        $power="1";
        $sql="select * from user where username='$username'";
        $res= $this->sqltool->sqlAction($sql);
        $data=$res->fetch_all(PDO::FETCH_ASSOC);
        if ($data!=null and $password==$data[0][2] and $power==$data[0][3]){
            $token=$this->setToken($username);
            $json = json_encode(array(
                "code"=>200,
                "message"=>"登录成功！",
                "username"=> $username,
                "token"=> $token
            ),JSON_UNESCAPED_UNICODE);
            //转换成字符串JSON
            $redis = new Redis();
            $redis->connect('152.136.245.47', 6379);
            $redis->set($username, $token,3000);
            $redis->close();
            echo($json);
        }else{
            $json = json_encode(array(
                "code"=>20003,
                "message"=>"密码错误！",
                "username"=> $username
            ),JSON_UNESCAPED_UNICODE);
            //转换成字符串JSON
            echo($json);
        }


        return false;
    }

    public function registerAction(){
        $this->sqltool = new Sqltool();
        $request = @file_get_contents('php://input');
        $request = json_decode($request,TRUE);
        $username = $request['username'];
        $password = $request['password'];
        $power="1";
        $sql="select * from user where username='$username'";
        $res= $this->sqltool->sqlAction($sql);
        $data=$res->fetch_all(PDO::FETCH_ASSOC);
        if ($data==null){
            //注册操作
            $sqlinsert="INSERT INTO  user (username, password, power) values ('$username','$password','$power')";
            $stutas=$this->sqltool->sqlAction($sqlinsert);
            if($stutas){
                $json = json_encode(array(
                    "code"=>200,
                    "message"=>"注册成功!",
                    "success"=> true
                ),JSON_UNESCAPED_UNICODE);

            }else{
                $json = json_encode(array(
                    "code"=>40002,
                    "message"=>"插入数据库出错!",
                    "success"=> false
                ),JSON_UNESCAPED_UNICODE);

            }
            echo($json);

        }else{//查出来内容
            $json = json_encode(array(
                "code"=>40002,
                "message"=>"注册失败这个账号被人抢了！",
                "success"=> false
            ),JSON_UNESCAPED_UNICODE);
            //转换成字符串JSON
            echo($json);
        }


        return false;
    }
}