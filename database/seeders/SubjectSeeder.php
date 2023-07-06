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
        $titleEn = ['Dynamics', 'Static', 'Algebra and Trigonometry', 'Calculus', 'Spatial Engineering'];
        $titleAr = ['ديناميكا', 'استاتيكا', 'جبر وحساب مثلثات', 'تفاضل وتكامل', 'هندسة فراغية'];
        for ($i = 3; $i <= 5; $i++) {
            for ($j = 0; $j < 5; $j++) {
                DB::table('subjects')->insert([
                    'title_en'=>$titleEn[$j],
                    'title_ar'=>$titleAr[$j],
                    'semester_id'=>$i,
                ]);
            }
        }
    }
}
