<?php

namespace Database\Seeders;

use App\Models\Lookups;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LookupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $lookups = [
            [
                'is_managed' => 1,
                'parent_id' => 0,
                'master_key' => 'province',
                'name_ar' => 'المحافظات',
                'name_en' => 'Provinces',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 0,
                'master_key' => 'city',
                'name_ar' => 'المدن',
                'name_en' => 'Cities',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 0,
                'master_key' => 'area',
                'name_ar' => 'الأحياء',
                'name_en' => 'Areas',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 1,
                'master_key' => 'province',
                'name_ar' => 'محافظات قطاع غزة',
                'name_en' => 'Gaza Strip',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 1,
                'master_key' => 'province',
                'name_ar' => 'محافظات الضفة الغربية',
                'name_en' => 'West Bank',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 4,
                'master_key' => 'city',
                'name_ar' => 'مدينة غزة',
                'name_en' => 'Gaza City',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 4,
                'master_key' => 'city',
                'name_ar' => 'خانيونس',
                'name_en' => 'Khanyounes',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 4,
                'master_key' => 'city',
                'name_ar' => 'رفح',
                'name_en' => 'Rafah',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 6,
                'master_key' => 'area',
                'name_ar' => 'غزة',
                'name_en' => 'Gaza',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 6,
                'master_key' => 'area',
                'name_ar' => 'مخيم الشاطئ',
                'name_en' => 'Shati Camp',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 7,
                'master_key' => 'area',
                'name_ar' => 'بني سهيلة',
                'name_en' => 'Bani Suhayla',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 7,
                'master_key' => 'area',
                'name_ar' => 'عبسان',
                'name_en' => 'Abasan',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 8,
                'master_key' => 'area',
                'name_ar' => 'الشابورة',
                'name_en' => 'Shabourah',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 0,
                'master_key' => 'age_group',
                'name_ar' => 'المرحلة العمرية',
                'name_en' => 'Age Group',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 14,
                'master_key' => 'age_group',
                'name_ar' => 'روضة',
                'name_en' => 'Kindergarten',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 15,
                'master_key' => 'age_group',
                'name_ar' => 'بستان',
                'name_en' => 'grove',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 15,
                'master_key' => 'age_group',
                'name_ar' => 'تمهيدي',
                'name_en' => 'preliminary',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 14,
                'master_key' => 'age_group',
                'name_ar' => 'ابتدائي',
                'name_en' => 'Primary',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 18,
                'master_key' => 'age_group',
                'name_ar' => 'الأول',
                'name_en' => 'The first',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 18,
                'master_key' => 'age_group',
                'name_ar' => 'الثاني',
                'name_en' => 'الثاني',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 18,
                'master_key' => 'age_group',
                'name_ar' => 'الثالث',
                'name_en' => 'الثالث',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 18,
                'master_key' => 'age_group',
                'name_ar' => 'الرابع',
                'name_en' => 'الرابع',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 18,
                'master_key' => 'age_group',
                'name_ar' => 'الخامس',
                'name_en' => 'الخامس',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 18,
                'master_key' => 'age_group',
                'name_ar' => 'السادس',
                'name_en' => 'السادس',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 14,
                'master_key' => 'age_group',
                'name_ar' => 'اعدادي',
                'name_en' => 'Preparatory',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 25,
                'master_key' => 'age_group',
                'name_ar' => 'السابع',
                'name_en' => 'السابع',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 25,
                'master_key' => 'age_group',
                'name_ar' => 'الثامن',
                'name_en' => 'الثامن',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 25,
                'master_key' => 'age_group',
                'name_ar' => 'التاسع',
                'name_en' => 'التاسع',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 14,
                'master_key' => 'age_group',
                'name_ar' => 'ثانوي',
                'name_en' => 'Secondary',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 29,
                'master_key' => 'age_group',
                'name_ar' => 'العاشر',
                'name_en' => 'العاشر',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 29,
                'master_key' => 'age_group',
                'name_ar' => 'الحادي عشر علمي',
                'name_en' => 'الحادي عشر علمي',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 29,
                'master_key' => 'age_group',
                'name_ar' => 'الحادي عشر ادبي',
                'name_en' => 'الحادي عشر ادبي',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 29,
                'master_key' => 'age_group',
                'name_ar' => 'الثاني عشر علمي',
                'name_en' => 'الثاني عشر علمي',
                'level' => '2',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 29,
                'master_key' => 'age_group',
                'name_ar' => 'الثاني عشر ادبي',
                'name_en' => 'الثاني عشر ادبي',
                'level' => '2',
            ],




        ];

        foreach ($lookups as $lookup) {
            Lookups::firstOrCreate(
                $lookup
            );
        }

    }
}
