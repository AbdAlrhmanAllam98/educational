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
        $titleAr = ['الترم الأول', 'الترم الثاني'];
        $titleEn = ['First semester', 'Second semester'];
        for ($i = 1; $i < 3; $i++) {
            for ($j = 0; $j < 2; $j++) {
                DB::table('semesters')->insert([
                    'title_en' => $titleEn[$j],
                    'title_ar' => $titleAr[$j],
                    'year_id' => $i,
                ]);
            }
        }
        DB::table('semesters')->insert([
            'title_en'=>'Third grade secondary',
            'title_ar'=>'الصف الثالث الثانوي',
            'year_id'=>3,
        ]);
    }
}
