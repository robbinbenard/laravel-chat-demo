<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Robbin Benard',
            'email' => 'robbinbenard@gmail.com',
            'password' => Hash::make('secret'),
        ]);
    }
}
