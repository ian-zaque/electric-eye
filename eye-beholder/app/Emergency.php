<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Contracts\Auditable;

class Emergency extends Model //implements Auditable
{
    use SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'emergencies';

    protected $fillable = [
        "name", "description", "interest_zone_id",
    ];

    public function emergency_parameters(){
        return $this->hasMany('App\EmergencyParameters', "emergency_id");
    }

    public function interest_zone(){
        return $this->belongsTo('App\InterestZone', 'interest_zone_id');
    }

}
