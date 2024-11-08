<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class SubscribeHazardDataTopic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt-topic-hazardData:subscribe';

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
            // Processar a mensagem recebida
            // echo "Mensagem recebida no tópico '{$topic}': {$message}\n";
        }, 0);

        // Iniciar o loop de escuta
        $mqtt->loop(true);

        return 0;
    }
}
