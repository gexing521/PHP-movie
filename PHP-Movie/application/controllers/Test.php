<?php
$redis = new Redis();
$redis->connect("152.136.245.47", 6379);
$res=$redis->get("gexing1Array");
$arr = json_decode($res, true);
print_r($arr);