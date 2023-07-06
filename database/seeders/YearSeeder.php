<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titleAr = ['الصف الأول الثانوي', 'الصف الثاني الثانوي', 'الصف الثالث الثانوي'];
        $titleEn = ['First grade secondary', 'Second grade secondary', 'Third grade secondary'];
        for ($i = 0; $i < 3; $i++) {
            DB::table('years')->insert([
                'title_en'=>$titleEn[$i],
                'title_ar'=>$titleAr[$i],
            ]);
        }
    }
}
