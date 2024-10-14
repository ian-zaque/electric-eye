<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Contracts\Auditable;

class SensorEmergency extends Model //implements Auditable
{
    use SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'sensors_emergencies';

    protected $fillable = [
        "sensor_id", "emergency_id",
    ];

    public function sensor(){
        return $this->belongsTo(Sensor::class);
    }

    public function emergency(){
        return $this->belongsTo(Emergency::class);
    }

}
