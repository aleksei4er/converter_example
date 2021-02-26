<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate([
            'id' => 1
        ], [
            'id' => 1,
            'name' => 'Example',
            'email' => 'example@mail.ru',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('anything'),
        ]);
    }
}
