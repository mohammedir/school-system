<?php

namespace Database\Seeders;

 use App\Models\Lands;
 use Illuminate\Database\Seeder;

class LandSeeder extends Seeder
{
    public function run()
    {
        Lands::create([
            'investor_id' => 1,
            'land_description' => 'أرض 500 متر للاستثمار',
            'province_cd' => 4,
            'city_cd' => 7,
            'district_cd' => 11,
            'address' => 'الرمال الجنوبي',
            'area' => 500.00,
            'plot_number' => '995',
            'parcel_number' => '205',
            'ownership_type_cd' => 16,
            'borders' => 'الحد الشمالي: شارع 10 متر الحد الجنوبي: شارع 12 متر الحد الشرقي: أرض 450 متر الحد الغربي: أرض 250 متر',
            'services' => 'توفر مياه، كهرباء، خط انترنت',
            'long' => '15487874.00',
            'lat' => '5488787.00',
            'price' => 85000,
            'valuator_id' => 2,
            'valuation_status_cd' => 35,
            'valuation_price' => 75000,
            'valuation_notes' => 'برجاء تعديل سعر الأرض إلى 75000$',
            'legal_partner_id' => 3,
            'legal_status_cd' => 39,
            'legal_notes' => 'بيانات ملكية الأرض سليمة',
            'legal_decline_reasons' => null,
        ]);
    }
}
