<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Contracts\Auditable;

class EmergencyParameter extends Model //implements Auditable
{
    use SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'emergency_parameters';

    protected $fillable = [
        "name", "value", "emergency_id",
    ];

    public function emergency(){
        return $this->belongsTo('App\Emergency', 'emergency_id');
    }

}
