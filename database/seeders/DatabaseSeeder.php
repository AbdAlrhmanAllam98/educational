<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::insert('insert into admins (name,email,password) values ("Allam","allam@gmail.com","123456")');
        $this->call(YearSeeder::class);
        $this->call(SemesterSeeder::class);
        $this->call(SubjectSeeder::class);
    }
}
