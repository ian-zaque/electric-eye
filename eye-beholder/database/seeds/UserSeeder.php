<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(!User::first()){
            $user = new User();
            $user->name = 'Ian Zaque Santos';
            $user->email = 'ianzaque.uefs@gmail.com';
            $user->password = Hash::make("");
            // 'user_role_id' => 1
        }

    }
}
