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
        // $nameAr = ['ديناميكا', 'استاتيكا', 'جبر', 'حساب مثلثات', 'تفاضل وتكامل', 'هندسة فراغية'];
        $firstSubjectsAr = ['جبر', 'حساب مثلثات', 'هندسة'];
        $firstSubjectsEn = ['Algebra', 'Trigonometry', 'Engineering'];
        for ($i = 1; $i <= 2; $i++) {
            for ($j = 0; $j < count($firstSubjectsAr); $j++) {
                DB::table('subjects')->insert([
                    'name_en' => $firstSubjectsEn[$j],
                    'name_ar' => $firstSubjectsAr[$j],
                    'code' => "YEAR-1-SEMESTER-$i-GENERAL-" . $firstSubjectsEn[$j],
                    'semester_id' => $i,
                ]);
            }
        }

        $thirdSubjectsAr = ['استاتيكا', 'ديناميكا', 'جبر', 'هندسة فراغية', 'تفاضل وتكامل', 'احصاء'];
        $thirdSubjectsEn = ['Static', 'Dynamics', 'Algebra', 'Spatial Engineering', 'Calculus', 'Statistics'];
        for ($j = 0; $j < count($thirdSubjectsAr); $j++) {
            DB::table('subjects')->insert([
                'name_en' => $thirdSubjectsEn[$j],
                'name_ar' => $thirdSubjectsAr[$j],
                'code' => "YEAR-3-SEMESTER-0-GENERAL-" . $thirdSubjectsEn[$j],
                'semester_id' => 7,
            ]);
        }
    }
}
