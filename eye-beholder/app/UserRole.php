<?php

namespace App;

use App\UserRoleAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Contracts\Auditable;

class UserRole extends Model //implements Auditable
{
    use SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'user_roles';

    protected $fillable = [
        "role"
    ];

    // public function user_role_actions(){
    //     return $this->hasMany(UserrRoleAction::class, 'id', 'user_role_id');
    // }


}
