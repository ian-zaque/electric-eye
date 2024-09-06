<?php

namespace App\Services;
use PhpMqtt\Client\Facades\MQTT;

class MqttPublisherService
{   
    public function publishQoS0($topic, $data){
        MQTT::publish($topic, $data);
    }

    public function publishQoS1($topic, $data){
        $mqtt = MQTT::connection();
        $mqtt->publish($topic, $data, 1, true);
        $mqtt->loop(true);
    }

    public function publishQoS2($topic, $data) {
        $mqtt = MQTT::connection();
        $mqtt->publish($topic, $data, 2, true); // Retain the message
        $mqtt->loop(true);
    }
}