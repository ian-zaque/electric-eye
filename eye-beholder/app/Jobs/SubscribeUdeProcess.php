<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpMqtt\Client\Facades\MQTT;

class SubscribeUdeProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $topic;
    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($topic, $data)
    {
        $this->topic = $topic;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        MQTT::publish($this->topic, $this->data, true);
        // MQTT::disconnect();
    }
}
