<?php

namespace App\Services;

use Analyze;
use Carbon\Carbon;
use RdKafka\Conf;
use RdKafka\Producer;
use Google\Protobuf\Timestamp;

class AnalyzeService
{
    public $producer;
    public $topic;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $brokers = config('services.kafka.kafka_broker_host');
        $conf = new Conf();
        $conf->set('metadata.broker.list', $brokers);
        $this->producer = new Producer($conf);
        $this->topic = $this->producer->newTopic(config('services.kafka.topic'));
    }


    public function produce($request, $duration)
    {
        $payload = $this->serialize($request, $duration);
        $this->topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload);
        $this->producer->poll(0);
        $result = $this->producer->flush(10000);
        RD_KAFKA_RESP_ERR_NO_ERROR === $result ?? throw new \RuntimeException('Was unable to flush, messages might be lost!');
    }

    protected function serialize($request, $duration)
    {
        $createdAtFormatted = $this->parseToGoogleProtobufTimestamp(Carbon::now());

        $eventStoreMessage = new Analyze();
        $eventStoreMessage->setIp($request->ip());
        $eventStoreMessage->setAgent($request->header('User-Agent'));
        $eventStoreMessage->setPath($request->path());
        $eventStoreMessage->setDuration($duration);
        $eventStoreMessage->setCreatedAt($createdAtFormatted);

        return $eventStoreMessage->serializeToString();
    }

    protected function parseToGoogleProtobufTimestamp(Carbon $createdAt)
    {
        $protoTimestamp = new Timestamp();
        $protoTimestamp->setSeconds($createdAt->timestamp);
        $protoTimestamp->setNanos(0);
        return $protoTimestamp;
    }
}
