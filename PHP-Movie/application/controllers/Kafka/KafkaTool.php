<?php
class KafkaTools extends Yaf_Controller_Abstract{
    public function kafkaAction($info){
        $objRdKafka = new RdKafka\Producer();
        $objRdKafka->addBrokers("152.136.245.47:9092");
        $oObjTopic = $objRdKafka->newTopic("gexing");
        $oObjTopic->produce(RD_KAFKA_PARTITION_UA, 0, $info);
        sleep(1);
    }

}