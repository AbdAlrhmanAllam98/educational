<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstSubjectsIds = ['1', '2', '3'];
        for ($i = 1; $i <= 2; $i++) {
            for ($j = 0; $j < count($firstSubjectsIds); $j++) {
                DB::table('subjects')->insert([
                    'code' => "1-$i-0-" . $firstSubjectsIds[$j],
                    'semester_code' => "1-$i-0",
                ]);
            }
        }

        $secondSubjects = [
            "second_1_1_Ids" => ['1', '2', '4', '5', '7'],
            "second_1_2_Ids" => ['1', '2', '5'],
            "second_2_1_Ids" => ['1', '2', '5', '8', '9'],
            "second_2_2_Ids" => ['1', '5', '9'],
        ];
        for ($i = 1; $i <= 2; $i++) {
            for ($j = 1; $j <= 2; $j++) {
                foreach ($secondSubjects["second_" . $i . "_" . $j . "_Ids"] as $value) {
                    DB::table('subjects')->insert([
                        'code' => "2-$i-$j-" . $value,
                        'semester_code' => "2-$i-$j",
                    ]);
                }
            }
        }


        $thirdSubjectsIds = ['7', '8', '1', '4', '6', '10'];
        for ($j = 0; $j < count($thirdSubjectsIds); $j++) {
            DB::table('subjects')->insert([
                'code' => "3-0-0-" . $thirdSubjectsIds[$j],
                'semester_code' => "3-0-0",
            ]);
        }
    }
}
