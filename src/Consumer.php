<?php
$config = new RdKafka\Conf();
$config->set('metadata.broker.list', 'kafka');

$rk = new RdKafka\Consumer($config);

$topic = $rk->newTopic("ecommerce_order");
$topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);

while (true) {
    $msg = $topic->consume(0, 1000);
    if (null === $msg || $msg->err === RD_KAFKA_RESP_ERR__PARTITION_EOF) {
        continue;
    } elseif ($msg->err) {
        echo $msg->errstr(), "\n";
        break;
    } else {
        echo $msg->payload, "\n";
    }
}
