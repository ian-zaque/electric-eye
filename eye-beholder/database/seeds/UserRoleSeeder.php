<?php

use Illuminate\Database\Seeder;
use App\UserRole;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!UserRole::first()){
            $user_role = new UserRole();
            $user_role->role = "Comum";
            $user_role->save();

            $user_role = new UserRole();
            $user_role->role = "Administrador";
            $user_role->save();
        }
    }
}
