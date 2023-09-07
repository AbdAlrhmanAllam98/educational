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
        $nameAr = ['الترم الأول', 'الترم الثاني'];
        $nameEn = ['First semester', 'Second semester'];
        $types = ['GENERAL', 'SCIENTIFIC', 'LITERARY'];


        for ($j = 1; $j <= 2; $j++) {
            DB::table('semesters')->insert([
                'name_en' => $nameEn[$j - 1],
                'name_ar' => $nameAr[$j - 1],
                'type' => $types[0],
                'code' => "YEAR-1-SEMESTER-$j-" . $types[0],
                'year_id' => 1,
            ]);
        }
        for ($j = 1; $j <= 2; $j++) {
            for ($k = 1; $k < 3; $k++) {
                DB::table('semesters')->insert([
                    'name_en' => $nameEn[$j - 1],
                    'name_ar' => $nameAr[$j - 1],
                    'type' => $types[$k],
                    'code' => "YEAR-2-SEMESTER-$j-" . $types[$k],
                    'year_id' => 2,
                ]);
            }
        }

        DB::table('semesters')->insert([
            'name_en' => 'Third grade secondary',
            'name_ar' => 'الصف الثالث الثانوي',
            'year_id' => 3,
            'type' => "GENERAL",
            'code' => "YEAR-3-SEMESTER-0-" . $types[0],

        ]);
    }
}
