<?php
error_reporting(0);
require("SqlTool/SqlCon.php");
require("TokenCheck/Token.php");
require("Kafka/KafkaTool.php");

class MovieController extends Yaf_Controller_Abstract{

    public function allListAction(){

        $this->sqltool = new Sqltool();
        $this->tokenCheck=new tokenCheck();

        $request = @file_get_contents('php://input');
        $request = json_decode($request,TRUE);
        $token = $request['token'];
        $username = $request['username'];
        $status=$this->tokenCheck->tokenAction($username,$token);

        if($status){
            $sql="select * from movie";
            $res= $this->sqltool->sqlAction($sql);
            $data=$res->fetch_all(PDO::FETCH_ASSOC);

            $json = json_encode(array(
                "code"=>200,
                "message"=>"获取电影数据成功！",
                "data"=>$data
            ),JSON_UNESCAPED_UNICODE);
            echo($json);
        }else{
            $json = json_encode(array(
                "code"=>40001,//权限不对
                "message"=>"登陆失效",
                "data"=> ""
            ),JSON_UNESCAPED_UNICODE);
            echo($json);
        }
        return false;

    }

    public function insertAction(){
        $this->sqltool = new Sqltool();
        $this->tokenCheck=new tokenCheck();
        $this->kafkatool=new KafkaTools();
        $redis = new Redis();
        $redis->connect('152.136.245.47', 6379);
        $request = @file_get_contents('php://input');
        $request = json_decode($request,TRUE);
        $token = $request['token'];
        $username = $request['username'];
        $m_id = $request['m_id'];
        $star = $request['star'];
        $status=$this->tokenCheck->tokenAction($username,$token);
        if($status){
            $sql="INSERT INTO score (username,m_id,star) VALUES ('$username', $m_id ,'$star') ";
            $res= $this->sqltool->sqlAction($sql);
                if($res){
                    $sum=$redis->get("sum".$username);
                    if(!$sum){
                        $redis->set("sum".$username,0);
                    };
                    $sql="select count(id) from score where username='$username'";
                    $res= $this->sqltool->sqlAction($sql);
                    $data=$res->fetch_all(PDO::FETCH_ASSOC);
                    if($data[0][0]-$sum>2){
                        $redis->set("sum".$username,$data[0][0]);
                        $this->kafkatool->kafkaAction($username);
                    }
                    $json = json_encode(array(
                        "code"=>200,
                        "message"=>"评分成功！",
                        "data"=>$data
                    ),JSON_UNESCAPED_UNICODE);
                }else{
                    $json = json_encode(array(
                        "code"=>20003,
                        "message"=>"评分失败！",
                        "data"=>null
                    ),JSON_UNESCAPED_UNICODE);
                }
                echo($json);
        }else{
            $json = json_encode(array(
                "code"=>40001,//权限不对
                "message"=>"登陆失效",
                "data"=> ""
            ),JSON_UNESCAPED_UNICODE);
            echo($json);
        }
        return false;

    }
    public function RecoAction(){
        $redis = new Redis();
        $redis->connect("152.136.245.47", 6379);
        $request = @file_get_contents('php://input');
        $request = json_decode($request,TRUE);
        $username = $request['username'];
        $res=$redis->get($username."Array");
        $arr = json_decode($res, true);
        $json = json_encode(array(
            "code"=>200,
            "message"=>"",
            "data"=> $arr
        ),JSON_UNESCAPED_UNICODE);
        echo($json);
        return false;
    }
}
