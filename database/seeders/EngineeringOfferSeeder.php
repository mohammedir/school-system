<?php

namespace Database\Seeders;

use App\Models\EngineeringOffer;
use Illuminate\Database\Seeder;

class EngineeringOfferSeeder extends Seeder
{
    public function run()
    {
        EngineeringOffer::create([
            'project_id' => 1,
            'engineering_partner_id' => 1,
            'technical_proposal' => null,
            'financial_proposal' => null,
            'total_price' => 4434.00,
            'duration' => 15,
            'offer_notes' => 'عرض السعر موضح في المرفقات',
            'status_cd' => 62,
            'created_at' => '2025-06-18 07:20:20',
            'updated_at' => '2025-06-18 07:20:20',
        ]);
    }
}
