<?php

namespace App\Services;

use PhpMqtt\Client\Facades\MQTT;
use App\Jobs\UpdateNodeTableProcess;
use App\Jobs\ConfigProcess;

class MqttPublisherService
{   
    public function subscribeUde($mac_id){
        $topic = 'subscribe';
        $id_mac_json_data = json_encode([ 'id_mac' => strval($mac_id) ]);

        \App\Jobs\SubscribeUdeProcess::withChain([
            new UpdateNodeTableProcess,
            new ConfigProcess,
        ])
        ->dispatch($topic, $id_mac_json_data);
    }
}