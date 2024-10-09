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
        // $this->data = json_encode(Ude::with(['ude_class'])->get()->toArray());
        $this->data = "UMA BELA DE UMA MENSAGEM AQUI KKKKKKKK";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // var_dump($this->data);
        // Log::alert($this->data);
        // Log::warning(gettype($this->data));
        MQTT::publish($this->topic, $this->data, true);
        // MQTT::disconnect();
    }
}
