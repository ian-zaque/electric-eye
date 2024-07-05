<?php

namespace App;

use App\UserRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Contracts\Auditable;

class UserRoleAction extends Model //implements Auditable
{
    use SoftDeletes;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'user_role_actions';

    protected $fillable = [
        "action", "model", "user_role_id"
    ];

    public function user_role(){
        return $this->belongsTo("App\UserRole");
    }
}
