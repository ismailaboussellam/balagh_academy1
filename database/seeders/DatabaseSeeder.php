<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserAdmin;
use App\Models\UserStudent;
use App\Models\UserTeacher;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $adminUser = User::create([
            'email' => 'admin@academy.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        UserAdmin::create([
            'user_id' => $adminUser->id,
            'first_name' => 'Admin',
            'last_name' => 'User',
            'phone' => '0600000000',
            'position' => 'System Administrator',
        ]);

        // Create Student User
        $studentUser = User::create([
            'email' => 'student@example.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);

        UserStudent::create([
            'user_id' => $studentUser->id,
            'first_name' => 'Student',
            'last_name' => 'User',
            'email' => $studentUser->email,
            'phone_code' => '+212',
            'phone' => '0611111111',
            'profile_picture' => null,
            'gender' => 'male',
            'birth_day' => 1,
            'birth_month' => 1,
            'birth_year' => 2000,
            'nationality' => 'Moroccan',
            'residence_country' => 'Morocco',
            'domain' => 'ta3lim_quran',
            'fi2a' => 'kibar',
            'password' => Hash::make('password123'),
        ]);

        // Create Teacher User
        $teacherUser = User::create([
            'email' => 'teacher@example.com',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
        ]);

        UserTeacher::create([
            'user_id' => $teacherUser->id,
            'first_name' => 'Teacher',
            'last_name' => 'User',
            'birth_date' =>  '1980-01-01',
            'phone' => '0622222222',
            'address' => 'Teacher Address',
            'specialization' => 'Mathematics',
            'bio' => 'Experienced teacher with 10 years of experience',
        ]);

    }
}
