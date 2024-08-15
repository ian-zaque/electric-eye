<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Contracts\Auditable;

class MqttTopic extends Model //implements Auditable
{
    use SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'mqtt_topics';

    protected $fillable = [
        "topic", "description", "active"
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

}
