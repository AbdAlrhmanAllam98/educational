<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lesson::insert([
            ["name" => "مقدمة عن الأعداد المركبة", "subject_code" => "1-1-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "نوع جذري المعادلة التربيعية", "subject_code" => "1-1-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "العلاقة بين جذري المعادلة التربيعية ومعاملاتها", "subject_code" => "1-1-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "تكوين المعادلة التربيعية متي عُلم الجذر", "subject_code" => "1-1-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "إشارة الدالة", "subject_code" => "1-1-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "حل متباينة الدرجة الثانية في متغير واحد", "subject_code" => "1-1-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],

            ["name" => "الزاوية الموجهة", "subject_code" => "1-1-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "القياس الدائري والقياس الستيني لزاوية", "subject_code" => "1-1-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "الدوال المثلثية", "subject_code" => "1-1-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "الزوايا المنتسبة", "subject_code" => "1-1-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "التمثيل البياني للدوال المثلثية", "subject_code" => "1-1-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],

            ["name" => "تشابة المضلعات", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "تشابة المثلثات", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "العلاقة بين مساحتي مضلعين متشابهين", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "تطبيقات التشابه في الدائرة", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "المستقيمات المتوازية والأجزاء المتناسبة", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "نظرية تاليس", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "منصفا الزاوية والأجزاء المتناسبة", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "تطبيقات التناسب في الدائرة", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],

            ["name" => "تنظيم البيانات", "subject_code" => "1-2-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "جمع وطرح المصفوفات", "subject_code" => "1-2-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "ضرب المصفوفات", "subject_code" => "1-2-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "المحددات", "subject_code" => "1-2-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "المعكوس الضربي للمصفوفة", "subject_code" => "1-2-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "حل انظمة المتباينات الخطية بيانياً", "subject_code" => "1-2-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "البرمجة الخطية والحل الأمثل", "subject_code" => "1-2-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],

            ["name" => "المتطابقات المثلثية", "subject_code" => "1-2-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "حل المعادلات المثلثية", "subject_code" => "1-2-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "حل المثلث القائم", "subject_code" => "1-2-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "زوايا الارتفاع والانخفاض", "subject_code" => "1-2-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "القطاع الدائري", "subject_code" => "1-2-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "القطعة الدائرية", "subject_code" => "1-2-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "المساحات", "subject_code" => "1-2-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],

            ["name" => "المتجهات", "subject_code" => "1-2-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "العمليات علي المتجهات", "subject_code" => "1-2-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "تقسيم القطعة المستقيمة", "subject_code" => "1-2-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "معادلة الخط المستقيم", "subject_code" => "1-2-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "الزاوية بين مستقيمين", "subject_code" => "1-2-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "طول المستقيم المرسوم من نقطة معلومة مستقيمة علي مستقيم معلوم", "subject_code" => "1-2-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
            ["name" => "المعادلة العامة لمستقيم يمر بنقطة تقاطع مستقيمين معلومين", "subject_code" => "1-2-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "type" => "lesson", "created_at" => Carbon::now(Config::get('app.timezone')), "updated_at" => Carbon::now(Config::get('app.timezone'))],
        ]);
    }
}
