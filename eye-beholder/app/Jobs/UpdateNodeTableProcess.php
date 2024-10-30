<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use PhpMqtt\Client\Facades\MQTT;
use App\Ude;

class UpdateNodeTableProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $topic;
    private $data;
    private $udesEmergencies;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->topic = 'update_node_table';
        $udes = collect(Ude::with([
            'ude_class', 
            'sensors', 
            'sensors.type_sensor', 
            'sensors.emergencies', 
            'sensors.emergencies.emergency_parameters', 
            'interest_zone', 
            'interest_zone.region'
            ])
            ->get()->toArray());

        $array_item = null;
        $this->data = collect([]);
        $sensors = collect([]);
        $emergencies = collect([]);
        $this->udesEmergencies = collect([]);

        $processEmergencyParameters = function ($emergency) {
            return collect($emergency['emergency_parameters'])->mapWithKeys(function ($param) {
                return [$param['name'] => $param['value']];
            })->toArray();
        };
        
        $processEmergencies = function ($sensor) use ($processEmergencyParameters) {
            return collect($sensor['emergencies'])->mapWithKeys(function ($emergency) use ($processEmergencyParameters) {
                $emergency_name = $emergency['name'];
                $parameters = $processEmergencyParameters($emergency);
                return [$emergency_name => $parameters];
            })->toArray();
        };
        
        $udes->each(function ($ude) use ($sensors, $emergencies, $processEmergencies) {
            collect($ude['sensors'])->each(function ($sensor) use ($sensors, $emergencies, $processEmergencies) {
                $emergencies->push($processEmergencies($sensor));
                $sensors->push($sensor['type_sensor']['type']);
            });
        
            $array_item = [
                'MAC' => $ude['mac_id'],
                'class' => $ude['ude_class']['class'],
                'id_node' => $ude['id'],
                'Latitude' => $ude['latitude'],
                'Longitude' => $ude['longitude'],
                'region' => $ude['interest_zone']['region']['id'],
            ];

            $this->udesEmergencies = [
                $ude['mac_id'] => $array_item,
            ];
        
            $this->data->push($array_item);
        });

        // Armazene o parâmetro gerado em cache ou sessão
        $cache = Cache::remember('udes_emergencies_UNTP', now()->addMinutes(5), function () {
            return $this->udesEmergencies;
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
