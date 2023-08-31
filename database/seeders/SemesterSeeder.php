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
        $types = ['GENERAL', 'LITERARY', 'SCIENTIFIC'];
        for ($i = 1; $i < 3; $i++) {
            for ($j = 0; $j < 2; $j++) {
                for ($k = 0; $k < 3; $k++) {
                    DB::table('semesters')->insert([
                        'name_en' => $nameEn[$j],
                        'name_ar' => $nameAr[$j],
                        'type' => $types[$k],
                        'code' => "YEAR_SEMESTER-$i-$j-$k",
                        'year_id' => $i,
                    ]);
                }
            }
        }
        DB::table('semesters')->insert([
            'name_en' => 'Third grade secondary',
            'name_ar' => 'الصف الثالث الثانوي',
            'year_id' => 3,
            'type' => "GENERAL",
            'code' => "YEAR_SEMESTER-GENERAL",

        ]);
    }
}
