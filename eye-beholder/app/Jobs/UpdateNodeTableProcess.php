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
        $this->data = [];
        $this->udesEmergencies = [];

        $array_item = null;
        $sensors = [];
        $emergencies = [];
        $current_ude = Cache::pull('current_ude');

        $udes = Ude::with([
            'ude_class', 
            'sensors', 
            'sensors.type_sensor', 
            'sensors.emergencies', 
            'sensors.emergencies.emergency_parameters', 
            'interest_zone', 
            'interest_zone.region'
        ])->get();

        // Função para processar parâmetros de emergência
        $processEmergencyParameters = function ($emergency) {
            $parameters = [];
            foreach ($emergency['emergency_parameters'] as $param) {
                $parameters[$param['name']] = $param['value'];
            }
            return $parameters;
        };

        // Função para processar emergências de um sensor
        $processEmergencies = function ($sensor) use ($processEmergencyParameters) {
            $sensorEmergencies = [];
            foreach ($sensor['emergencies'] as $emergency) {
                $sensorEmergencies[$emergency['name']] = $processEmergencyParameters($emergency);
            }
            return $sensorEmergencies;
        };

        // Iteração principal
        foreach ($udes as $ude) {
            $array_item = [
                'MAC' => $ude->mac_id,
                'class' => $ude->ude_class->class,
                'name' => $ude->name,
                'id_node' => $ude->id,
                'Latitude' => $ude->latitude,
                'Longitude' => $ude->longitude,
                'region' => $ude->interest_zone->region->id,
            ];

            foreach ($ude->sensors as $sensor) {
                if ($ude->mac_id == $current_ude) {
                    $this->udesEmergencies = [
                        $ude->mac_id => $array_item,
                        'emergencies' => $emergencies[] = $processEmergencies($sensor),
                    ];
                }
            }

            $this->data[] = $array_item;
        }

        // Armazene o parâmetro gerado em cache ou sessão
        Cache::put('udes_emergencies_UNTP', $this->udesEmergencies, now()->addMinutes(1));              // UNTP => Update Node Table Process
        $this->data = json_encode(["udes" => $this->data]);

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
