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
        $nameEn = ['Dynamics', 'Static', 'Algebra and Trigonometry', 'Calculus', 'Spatial Engineering'];
        $nameAr = ['ديناميكا', 'استاتيكا', 'جبر وحساب مثلثات', 'تفاضل وتكامل', 'هندسة فراغية'];
        for ($x = 1; $x <= 3; $x++) {
            for ($i = 1; $i <= 5; $i++) {
                for ($j = 0; $j < 5; $j++) {
                    DB::table('subjects')->insert([
                        'name_en' => $nameEn[$j],
                        'name_ar' => $nameAr[$j],
                        'code' => "YEAR-$x-SEMESTER-$i-TYPE-1-SUBJECT-$j",
                        'semester_id' => $i,
                    ]);
                }
            }
        }
    }
}
