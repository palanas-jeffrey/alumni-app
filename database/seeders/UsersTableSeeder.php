<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::firstOrCreate([
            'alumni_id' => 'ALU-2025-0001',
        ], [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'middle_name' => '',
            'maiden_name' => '',
            'date_of_birth' => '2000-01-01',
            'gender' => 'Male',
            'civil_status' => 'single',
            'program_id' => 1,
            'mobile_number' => '',
            'batch_year' => '2024-2025',
            'email' => 'johndoe@gmail.com',
            'current_address' => '',
            'permanent_address' => '',
            'password' => Hash::make('1234qwer'), 
            'email_verified_at' => \Carbon\Carbon::now(),
        ]);

        User::factory()->count(20)->create();
    }
}
