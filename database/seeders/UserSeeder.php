<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder 
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'email'             => 'maulanaakurniaa@yahoo.com',
            'password'          => \Hash::make('1221'),
            'name'              => 'Maulana Kurnia'
        ]);

        User::insert([
            'email'             => 'langitermenung@gmail.com',
            'password'          => \Hash::make('1221'),
            'name'              => 'Dhiani Kurnia Sari'
        ]);
        
        User::insert([
            'email'             => 'demasarvin@gmail.com',
            'password'          => \Hash::make('1221'),
            'name'              => 'Demas Arvin'
        ]);
    }
}