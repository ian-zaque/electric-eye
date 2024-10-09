<?php

namespace App\Services;

use PhpMqtt\Client\Facades\MQTT;
use App\Jobs\UpdateNodeTableProcess;

class MqttPublisherService
{   
    public function subscribeUde($mac_id){
        $topic = 'subscribe';
        $id_mac_json_data = json_encode([ 'id_mac' => strval($mac_id) ]);

        \App\Jobs\SubscribeUdeProcess::withChain([
            new UpdateNodeTableProcess,
        ])
        ->dispatch($topic, $id_mac_json_data);
    }

    // private function publishQoS0($topic, $data){
    //     // dd($topic, $data);
    //     MQTT::publish($topic, $data);
    // }

    // private function publishQoS1($topic, $data){
    //     $mqtt = MQTT::connection();
    //     $mqtt->publish($topic, $data, 1, true);
    //     $mqtt->loop(true);
    // }

    // private function publishQoS2($topic, $data) {
    //     $mqtt = MQTT::connection();
    //     $mqtt->publish($topic, $data, 2, true); // Retain the message
    //     $mqtt->loop(true);
    // }
}