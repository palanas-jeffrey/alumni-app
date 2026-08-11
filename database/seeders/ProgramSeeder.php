<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('programs')->insert([
            [
                'program_abbreviation' => 'BSIT',
                'program_name' => 'Bachelor of Science in Information Technology',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_abbreviation' => 'BSCS',
                'program_name' => 'Bachelor of Science in Computer Science',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_abbreviation' => 'BSCPE',
                'program_name' => 'Bachelor of Science in Computer Engineering',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_abbreviation' => 'BSIS',
                'program_name' => 'Bachelor of Science in Information Systems',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
