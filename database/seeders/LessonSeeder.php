<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lesson::insert([
            ["name" => "مقدمة عن الأعداد المركبة", "subject_code" => "1-1-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "نوع جذري المعادلة التربيعية", "subject_code" => "1-1-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "العلاقة بين جذري المعادلة التربيعية ومعاملاتها", "subject_code" => "1-1-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "تكوين المعادلة التربيعية متي عُلم الجذر", "subject_code" => "1-1-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "إشارة الدالة", "subject_code" => "1-1-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "حل متباينة الدرجة الثانية في متغير واحد", "subject_code" => "1-1-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

            ["name" => "الزاوية الموجهة", "subject_code" => "1-1-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "القياس الدائري والقياس الستيني لزاوية", "subject_code" => "1-1-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "الدوال المثلثية", "subject_code" => "1-1-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "الزوايا المنتسبة", "subject_code" => "1-1-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "التمثيل البياني للدوال المثلثية", "subject_code" => "1-1-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

            ["name" => "تشابة المضلعات", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "تشابة المثلثات", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "العلاقة بين مساحتي مضلعين متشابهين", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "تطبيقات التشابه في الدائرة", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "المستقيمات المتوازية والأجزاء المتناسبة", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "نظرية تاليس", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "منصفا الزاوية والأجزاء المتناسبة", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "تطبيقات التناسب في الدائرة", "subject_code" => "1-1-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

            ["name" => "تنظيم البيانات", "subject_code" => "1-2-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "جمع وطرح المصفوفات", "subject_code" => "1-2-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "ضرب المصفوفات", "subject_code" => "1-2-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "المحددات", "subject_code" => "1-2-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "المعكوس الضربي للمصفوفة", "subject_code" => "1-2-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "حل انظمة المتباينات الخطية بيانياً", "subject_code" => "1-2-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "البرمجة الخطية والحل الأمثل", "subject_code" => "1-2-0-1", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

            ["name" => "المتطابقات المثلثية", "subject_code" => "1-2-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "حل المعادلات المثلثية", "subject_code" => "1-2-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "حل المثلث القائم", "subject_code" => "1-2-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "زوايا الارتفاع والانخفاض", "subject_code" => "1-2-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "القطاع الدائري", "subject_code" => "1-2-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "القطعة الدائرية", "subject_code" => "1-2-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "المساحات", "subject_code" => "1-2-0-2", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

            ["name" => "المتجهات", "subject_code" => "1-2-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "العمليات علي المتجهات", "subject_code" => "1-2-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "تقسيم القطعة المستقيمة", "subject_code" => "1-2-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "معادلة الخط المستقيم", "subject_code" => "1-2-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "الزاوية بين مستقيمين", "subject_code" => "1-2-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "طول المستقيم المرسوم من نقطة معلومة مستقيمة علي مستقيم معلوم", "subject_code" => "1-2-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["name" => "المعادلة العامة لمستقيم يمر بنقطة تقاطع مستقيمين معلومين", "subject_code" => "1-2-0-3", "created_by" => "b5aef93f-4eab-11ee-aa41-c84bd64a9918", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
        ]);
    }
}
