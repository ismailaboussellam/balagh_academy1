<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'phone_code' => '+212',
            'phone' => '600000000',
            'gender' => 'male',
            'birth_day' => 1,
            'birth_month' => 1,
            'birth_year' => 1990,
            'nationality' => 'maroc',
            'residence_country' => 'maroc',
            'user_type' => 'admin',
            'domain' => 'ta3lim_quran',
            'fi2a' => 'kibar',
            'password' => Hash::make('password'),
        ]);
    }
}
