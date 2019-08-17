<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'name' => 'User 1',
            'email' => 'user1@fti.ukdw.ac.id',
            'password' => bcrypt('password')
        ]);

        User::create([
            'name' => 'User 2',
            'email' => 'user2@fti.ukdw.ac.id',
            'password' => bcrypt('password')
        ]);
    }
}
