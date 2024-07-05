<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Contracts\Auditable;

class InterestZone extends Model //implements Auditable
{
    use SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'interest_zones';

    protected $fillable = [
        "region_id", "name", "description",
    ];

    public function region(){
        return $this->belongsTo('App\Region', 'region_id');
    }

    public function udes(){
        return $this->hasMany('App\Ude', 'interest_zone_id');
    }

}
