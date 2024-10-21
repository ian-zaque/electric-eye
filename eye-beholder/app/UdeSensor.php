<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Contracts\Auditable;

class UdeSensor extends Model //implements Auditable
{
    protected $table = 'udes_sensors';

    protected $fillable = [
        "sensor_id", "ude_id",
    ];

    public function sensor(){
        return $this->belongsTo(Sensor::class);
    }

    public function ude(){
        return $this->belongsTo(Ude::class);
    }
}
