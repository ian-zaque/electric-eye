<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Facades\MQTT;
use App\Ude;

class UpdateNodeTableProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $topic;
    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->topic = 'update_node_table';
        $udes = collect(Ude::with(['ude_class', 'interest_zone', 'interest_zone.region'])->get()->toArray());
        $this->data = collect([]);
        $array_item = null;

        $udes->each(function($item, $key){
            $array_item = [
                'MAC' => $item['mac_id'],
                'class' => $item['ude_class']['class'],
                'id_node' => $item['id'],
                'Latitude' => $item['latitude'],
                'Longitude' => $item['longitude'],
                'region' => $item['interest_zone']['region']['id'],
                // add here ude's associate emergencies
            ];

            $this->data->push($array_item);
        });

        $this->data = json_encode([ "udes" => $this->data->toArray() ]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        MQTT::publish($this->topic, $this->data, true);
    }
}
