<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Contracts\Auditable;

class Event extends Model //implements Auditable
{
    use SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'events';

    protected $fillable = [
        "ude_id", "region_id", "event", "timestamp",
    ];

    public function ude(){
        return $this->belongsTo(Ude::class);
    }

    public function region(){
        return $this->belongsTo('App\Region', 'region_id');
    }
}
