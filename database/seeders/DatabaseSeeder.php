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
        
        DB::insert('insert into students (full_name,email,password,birth_date,phone,parent_phone,national_id,year_id,semester_id) VALUES
        ("AbdAlrhman Allam","allam@gmail.com","123456","1997-04-16","01002317489","01147037357","29704160101653",1,1)');
    }
}
