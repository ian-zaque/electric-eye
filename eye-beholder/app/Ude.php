<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Contracts\Auditable;

class Ude extends Model //implements Auditable
{
    use SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'udes';

    protected $fillable = [
        "class_id", "interest_zone_id", "name", "mac_id", "latitude", "longitude"
    ];

    public function ude_class(){
        return $this->belongsTo('App\UdeClass', 'class_id');
    }

    public function interest_zone(){
        return $this->belongsTo('App\InterestZone', 'interest_zone_id');
    }

    public function sensors(){
        return $this->hasManyThrough(Sensor::class, UdeSensor::class, 'ude_id', 'id', 'id', 'sensor_id');
    }

}
