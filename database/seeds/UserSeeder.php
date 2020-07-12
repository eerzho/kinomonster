<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++){
            $name = "Юзер".$i;
            $email = "user".$i."@gmail.com";
            $password = bcrypt("user".$i);
            $role = rand(0,1);
            $data[] = [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => $role,
            ];
        }
        Db::table('users')->insert($data);
    }
}
