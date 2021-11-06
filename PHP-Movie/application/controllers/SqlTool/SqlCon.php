<?php
class Sqltool extends Yaf_Controller_Abstract{
    public function init(){

    }
    public function sqlAction($sql){
        $host='152.136.245.47';
        $user='root';
        $password='Xueting249!';
        $dbName='moviedata';

        $link=new mysqli($host,$user,$password,$dbName,3306);
        $link->query("SET NAMES utf8");
        if ($link->connect_error){
            die("连接失败：".$link->connect_error);
        }else{

            $res=$link->query($sql);
            return $res;
        }
    }

}