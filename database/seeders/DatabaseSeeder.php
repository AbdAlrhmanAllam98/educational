<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $password = Hash::make("123456");
        DB::insert("insert into admins (name,email,password) values ('Allam','allam@gmail.com', '$password')");
        $this->call(YearSeeder::class);
        $this->call(SemesterSeeder::class);
        $this->call(SubjectSeeder::class);

        DB::insert("insert into students (full_name,email,password,phone,parent_phone,national_id,year_id,semester_id) VALUES
        ('AbdAlrhman Allam','allam@gmail.com', '$password' ,'01002317489','01147037357','29704160101653',1,1)");
    }
}
