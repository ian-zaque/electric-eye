<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Contracts\Auditable;

class Sensor extends Model //implements Auditable
{
    use SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'sensors';

    protected $fillable = [
        "type_sensor_id", "description", "model"
    ];

    public function type_sensor(){
        return $this->belongsTo('App\TypeSensor', 'type_sensor_id');
    }

    public function emergencies(){
        return $this->hasManyThrough(Emergency::class, SensorEmergency::class, 'emergency_id', 'id');
    }

}
