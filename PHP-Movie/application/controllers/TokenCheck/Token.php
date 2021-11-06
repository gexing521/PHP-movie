<?php
class tokenCheck extends Yaf_Controller_Abstract{
    public function init(){

    }
    public function tokenAction($username,$token){
        $redis = new Redis();
        $redis->connect("152.136.245.47", 6379);
        if ($redis->connect_error){
            die("连接失败：".$redis->connect_error);
        }else{
            $token_redis=$redis->get($username);
            if($token==$token_redis){
                return true;
            }else{
                return false;
            }

        }
    }

}