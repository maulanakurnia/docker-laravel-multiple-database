<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder 
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::insert([
            'id'                => '1',
            'user_id'           => '1',
            'title'             => 'Create Database',
            'body'              => 'lorem ipsum'
        ]);

        Task::insert([
            'user_id'           => '1',
            'title'             => 'Create UI/UX',
            'body'              => 'lorem ipsum'
        ]);

        Task::insert([
            'user_id'           => '1',
            'title'             => 'Coding',
            'body'              => 'lorem ipsum'
        ]);

        Task::insert([
            'user_id'           => '2',
            'title'             => 'Go To Holiday',
            'body'              => 'lorem ipsum'
        ]);
    }
}