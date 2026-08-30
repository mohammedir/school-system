<?php

namespace Database\Seeders;

use App\Models\Contractors;
use App\Models\Lookups;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ContractorsSeeder extends Seeder
{
    public function run()
    {
        $status = Lookups::where('master_key', 'contractor_status')
            ->where('item_key', Contractors::STATUS_APPROVED)
            ->first();

            $Contractor = [
            [                
                'company_name' => 'مقاول 1',
                'mobile' => '0599123456',
                'province_cd' => 4,
                'city_cd' => 6,
                'district_cd' => 9,
                'address' => 'Gaza, Palestine',
                'experience_years' => 5,
                'status_cd' => $status?->id,
                'email' => 'contractor1@contractor.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [        
                'company_name' => 'مقاول 2',
                'mobile' => '0599123123',
                'province_cd' => 4,
                'city_cd' => 6,
                'district_cd' => 9,
                'address' => 'Gaza, Palestine',
                'experience_years' => 5,
                'status_cd' => $status?->id,
                'email' => 'contractor2@contractor.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        ];

        foreach ($Contractor as $data) {
            Contractors::create($data);
        }
    }
}

