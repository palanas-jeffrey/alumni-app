<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::firstOrCreate([
            'email' => 'admin07@ualumni.ph',
        ], [
            'first_name' => 'Admin07',
            'last_name' => 'Admin',
            'password' => Hash::make('1234qwer'),
            'email_verified_at' => \Carbon\Carbon::now(),
        ]);

        Admin::firstOrCreate([
            'email' => 'admin08@ualumni.ph',
        ], [
            'first_name' => 'Admin08',
            'last_name' => 'Admin',
            'password' => Hash::make('1234qwer'),
            'email_verified_at' => \Carbon\Carbon::now(),
        ]);
    }
}
