<?php
error_reporting(0);
require("SqlTool/SqlCon.php");
$sqltool = new Sqltool();
$sql="SELECT movie.movie_type FROM (select * from score where username='gexing' order by star limit 5) AS hobby1 LEFT JOIN movie ON movie.id= hobby1.m_id";
$res= $sqltool->sqlAction($sql);
$data=$res->fetch_all(PDO::FETCH_ASSOC);
$type=arr2str($data);
$sql="select hobby_id from hobby where username='gexing'";
$res= $sqltool->sqlAction($sql);

//if($res->num_rows==0){
//    $sql="INSERT INTO hobby (hobby.movie_type,hobby.username)VALUES('$type','gexing')";
//    $res= $sqltool->sqlAction($sql);
//}else{
//    $sql="update  hobby  set hobby.movie_type='1' where hobby.username='gexing'";
//    $res= $sqltool->sqlAction($sql);
//}
$array=explode(" ",$type);
$userArray=array_count_values ($array);
$sql="SELECT * FROM hobby where username !='gexing' ORDER BY RAND() LIMIT 5";
$res= $sqltool->sqlAction($sql);
$data=$res->fetch_all(PDO::FETCH_ASSOC);
if (sizeof($data)!=0){
    foreach ($data as $item){
        $arr=explode(" ",$item[2]);
        $arr=array_count_values ($arr);
        $arr=complement($arr,$userArray);
        $userArray=complement($userArray,$arr);
        ksort( $arr);
        ksort( $userArray );
        $res=cosarray(array_values($arr),array_values($userArray));
        $resArr[$item[1]]=$res;
    }
}
arsort($resArr);
$arrRes=[];
foreach ($resArr as $kay=>$value) {
    //先根据kay查出5条数据
    $sql = "select * from score where username='$kay' order by star,id DESC limit 5";
    $res = $sqltool->sqlAction($sql);
    $data = $res->fetch_all(PDO::FETCH_ASSOC);
    //获取movieid
    $arr = array_column($data, '2');
    $arrRes= array_merge_recursive($arrRes, $arr);
}
print_r($arrRes);
//查出当前用户
$sql = "select * from score where username='gexing' order by star,id DESC limit 5";
$res = $sqltool->sqlAction($sql);
$data = $res->fetch_all(PDO::FETCH_ASSOC);
$arr = array_column($data, '2');
print_r($arr );
$array = array_diff($arrRes, $arr);
print_r(array_slice($array,0,5) );
//计算cos
function cosarray($arr1,$arr2){

    $fm1 = 0;
    $fm2 = 0;
//开始计算cos
//计算分母1，分母1是第一个公式里面分母 “*”号左边的内容，分母二是右边的内容
    for($i=0;$i<sizeof($arr1);$i++){
        if($arr1[$i] != null){
            $fm1 += $arr1[$i] * $arr1[$i];
        }
    }
    $fm1 = sqrt($fm1);
    for($i=0;$i<sizeof($arr2);$i++){
        if($arr2[$i] != null){
            $fm2 += $arr2[$i] * $arr2[$i];
        }
    }
    $fm2 = sqrt($fm2);
//分子
    $fz=0;
    for($j=1;$j<9;$j++){
        if($arr1[$j] != null && $arr2[$j] != null){
            $fz += $arr1[$j] * $arr2[$j];
        }
    }
    return $fz/$fm1/$fm2;
}
function complement($arr1,$arr2){
    foreach ($arr2 as $kay=>$value){
        if (array_key_exists($kay, $arr1))
        {

        } else {
           $arr1[$kay]=0;
        }
    }
    return $arr1;
}

//二维转字符串
function arr2str ($arr)
{
    foreach ($arr as $v)
    {
        $v = join(",",$v); //可以用implode将一维数组转换为用逗号连接的字符串
        $temp[] = $v;
    }
    $t="";
    foreach($temp as $v){
        $t.=$v." ";
    }
    $t=substr($t,0,-1);
    return $t;
}