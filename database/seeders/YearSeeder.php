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
        // $nameAr = ['الصف الأول الثانوي', 'الصف الثاني الثانوي', 'الصف الثالث الثانوي'];
        // $nameEn = ['First grade secondary', 'Second grade secondary', 'Third grade secondary'];
        for ($i = 1; $i <= 3; $i++) {
            DB::table('years')->insert([
                'code' => "$i"
            ]);
        }
    }
}
