<?php

namespace Database\Seeders;

use App\Models\Investors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InvestorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $investors = [
            [
                'full_name' => 'محمد',
                'phone' => '28123456',
                'mobile' => '0599123456',
                'province_cd' => 4,
                'city_cd' => 6,
                'district_cd' => 10,
                'address' => 'الشجاعية',
                'yearly_income' => 55000,
                'email' => 'investor1@gmail.com',
                'password' => Hash::make('password'),
            ],
            [
                'full_name' => 'اياد',
                'phone' => '28111222',
                'mobile' => '0599111222',
                'province_cd' => 4,
                'city_cd' => 6,
                'district_cd' => 10,
                'address' => 'النصر',
                'yearly_income' => 65000,
                'email' => 'investor2@gmail.com',
                'password' => Hash::make('password'),

            ]
        ];

        /*foreach ($investors as $data) {
            Investors::create($data);
        }*/

    }
}
