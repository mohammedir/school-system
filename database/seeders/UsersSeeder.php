<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [                
                'email' => 'admin@gmail.com',
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'mobile_number' => '0599123456',
                'email_verified_at' => now()
            ],
            [                  
                'email' => 'evaluator@gmail.com',
                'name' => 'مثمن عقاري',
                'password' => Hash::make('password'),
                'mobile_number' => '0599111222',
                'email_verified_at' => now()
            ],
            [                  
                'email' => 'legal@gmail.com',
                'name' => 'شريك قانوني',
                'password' => Hash::make('password'),
                'mobile_number' => '0599111333',
                'email_verified_at' => now()
            ],
            [                  
                'email' => 'consultant@gmail.com',
                'name' => 'استشاري هندسي',
                'password' => Hash::make('password'),
                'mobile_number' => '0599112233',
                'email_verified_at' => now()
            ]
        ];

        foreach ($users as $data) {
            User::create($data);
        }
    }
}
