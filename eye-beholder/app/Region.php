<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Contracts\Auditable;

class Region extends Model //implements Auditable
{
    use SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'regions';

    protected $fillable = [
        "name", "description"
    ];

    public function interest_zones(){
        return $this->hasMany('App\Region', 'region_id');
    }
}
