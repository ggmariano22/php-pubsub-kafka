<?php
use RdKafka\Conf;
use RdKafka\Producer;

try {
    //code...
    $config = new Conf();
    $config->set('metadata.broker.list', 'kafka:9092');
    $config->set('request.required.acks', '1');
    
    $producer = new Producer($config);
    
    $topic = $producer->newTopic('ecommerce_order');
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'mensagem teste no kafka bro');

    for ($flushRetries = 0; $flushRetries < 3; $flushRetries++) {
        $result = $producer->flush(1000);
        if (RD_KAFKA_RESP_ERR_NO_ERROR === $result) {
            var_dump($result);
        }
    }

    if (RD_KAFKA_RESP_ERR_NO_ERROR !== $result) {
        throw new RuntimeException('Was unable to flush, messages might be lost!');
    }
} catch (\Throwable $th) {
    var_dump($th);
}
