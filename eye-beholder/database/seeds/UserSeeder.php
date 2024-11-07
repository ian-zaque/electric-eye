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
            $user->password = Hash::make("12344321");
            $user->user_role_id = 2;
            $user->email_verified_at = now();
            $user->save();

            $user = new User();
            $user->name = 'Thiago Jesus';
            $user->email = 'tcjesus@uefs.br';
            $user->password = Hash::make("12344321");
            $user->user_role_id = 2;
            $user->email_verified_at = now();
            $user->save();

            $user = new User();
            $user->name = 'Wild Freitas';
            $user->email = 'wfssantos@uefs.br';
            $user->password = Hash::make("12344321");
            $user->user_role_id = 2;
            $user->email_verified_at = now();
            $user->save();

            $user = new User();
            $user->name = 'Banca Ecomp';
            $user->email = 'ecomp@uefs.br';
            $user->password = Hash::make("12344321");
            $user->user_role_id = 1;
            $user->email_verified_at = now();
            $user->save();
        }

    }
}
