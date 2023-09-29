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
        DB::insert("insert into admins (id,user_name,password,is_super_admin) values ('b5aef93f-4eab-11ee-aa41-c84bd64a9918','SYSTEM', '$password',true)");
        $this->call(YearSeeder::class);
        $this->call(SemesterSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(LessonSeeder::class);

        DB::insert("insert into students (full_name,email,password,phone,parent_phone,national_id,semester_code) VALUES
        ('AbdAlrhman Allam','allam@gmail.com', '$password' ,'01002317489','01147037357','29704160101653','1-1-0')");
    }
}
