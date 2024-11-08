<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use PhpMqtt\Client\Facades\MQTT;

class ConfigProcess implements ShouldQueue
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
        $this->topic = 'config';
        $this->data =  json_encode(Cache::pull('udes_emergencies_UNTP'));
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
