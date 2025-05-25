<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminSeeder::class);

        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'student',
        ]);

        User::create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'teacher@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'teacher',
        ]);
    }
}
