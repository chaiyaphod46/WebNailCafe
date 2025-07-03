<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; 

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'phon' => '0899999999',
                'is_admin' => '1',
                'password' => bcrypt('1234')
            ],
            [
                'name' => 'user',
                'email' => 'user@user.com',
                'phon' => '0000000000',
                'is_admin' => '0',
                'password' => bcrypt('1234')
            ]

        ];
        foreach($user as $key => $value){
            User::create($value);
        }
    }
}
