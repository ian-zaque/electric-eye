<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Contracts\Auditable;

class UdeClass extends Model //implements Auditable
{
    use SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'ude_classes';

    protected $fillable = [
        "class"
    ];

    public function udes(){
        return $this->hasMany('App\Ude', "class_id");
    }

}
