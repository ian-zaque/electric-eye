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
}
