<?php
//这个文件持续单独运行因为要接收消息然后远程调用推荐服务
/**
 * 消费者消费消息
 *
 * 实现的例子来源于：
 *
 * https://github.com/arnaud-lb/php-rdkafka#examples
 */
error_reporting(0);

$objRdKafka = new RdKafka\Consumer();
$objRdKafka->setLogLevel(LOG_DEBUG);
$objRdKafka->addBrokers("152.136.245.47:9092");
$oObjTopic = $objRdKafka->newTopic("gexing");

/**
 * consumeStart
 *   第一个参数标识分区，生产者是往分区0发送的消息，这里也从分区0拉取消息
 *   第二个参数标识从什么位置开始拉取消息，可选值为
 *     RD_KAFKA_OFFSET_BEGINNING : 从开始拉取消息
 *     RD_KAFKA_OFFSET_END : 从当前位置开始拉取消息
 *     RD_KAFKA_OFFSET_STORED : 猜测跟RD_KAFKA_OFFSET_END一样
 */
$oObjTopic->consumeStart(0, RD_KAFKA_OFFSET_END);

while (true) {
    // 第一个参数是分区，第二个参数是超时时间
    $oMsg = $oObjTopic->consume(0, 1000);

    // 没拉取到消息时，返回NULL
    if (!$oMsg) {
        usleep(10000);
        continue;
    }

    if ($oMsg->err) {
        echo $oMsg->errstr(), "\n";
        break;
    } else {
        header('Content-type:text/html;charset=utf-8');
        $client = new Yar_Client("http://localhost/recommend/Recommend");
        $client->SetOpt(YAR_OPT_TIMEOUT, 0);
        $result=$client->recommendAction($oMsg->payload);
    }
}