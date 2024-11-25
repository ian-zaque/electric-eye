<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;
use App\Event;

class SubscribeHazardDataTopic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hazardData:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para inscrever o Electric Eye no tópico hazard_data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $topic = "hazard_data";

        // Conectar ao cliente MQTT
        $mqtt = MQTT::connection();

        // Definir o callback que será chamado ao receber uma mensagem no tópico
        $mqtt->subscribe($topic, function (string $topic, string $message) {
            // echo "Mensagem recebida no tópico '{$topic}': {$message}\n";

            $received_data = json_decode($message, true);
            $datetime = $received_data['timestamp']/1000;
            $datetime = date("Y-m-d H:i:s", $datetime);
            
            $eventData = [
                'region_id' => $received_data['region_id'],
                'ude_id' => $received_data['id_node'],
                'timestamp' => $datetime,
                'event' => json_encode($received_data['emergency']),
            ];
            $event = new Event();
            $event->fill($eventData)->save();
            // $event = Event::find($event->id);

            // echo "Salvando novo evento: '{$received_data}' \n\n ";

            // dd($received_data);

        }, 0);

        // Iniciar o loop de escuta
        $mqtt->loop(true);

        return 0;
    }
}
