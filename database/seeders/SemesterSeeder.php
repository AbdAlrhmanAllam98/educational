<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($j = 1; $j < 3; $j++) {
            DB::table('semesters')->insert([
                'code' => "1-$j-0",
                'year_code' => "1",
            ]);
        }


        for ($j = 1; $j <= 2; $j++) {
            for ($k = 1; $k < 3; $k++) {
                DB::table('semesters')->insert([
                    'code' => "2-$j-$k",
                    'year_code' => 2,
                ]);
            }
        }

        DB::table('semesters')->insert([
            'code' => "3-0-0",
            'year_code' => "3",
        ]);
    }
}
