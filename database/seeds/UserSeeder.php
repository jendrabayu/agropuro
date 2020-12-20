<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Iam Admin',
            'email' => 'admin@mail.com',
            'photo' => 'images/user/avatar-' . rand(1, 5) . '.png',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => 1, //admin
            'remember_token' => Str::random(10),
        ]);

        factory(User::class, 50)->create();
    }
}
