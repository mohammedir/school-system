<?php

namespace Database\Seeders;

use App\Models\Complaint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $complaints = [
            [
                'complainant_name' => 'أحمد محمد',
                'phone_number' => '0599123456',
                'type' => 'complaint',
                'details' => 'تأخر المعلم عن الحصة الدراسية',
                'status' => 'pending',
            ],
            [
                'complainant_name' => 'سارة علي',
                'phone_number' => '0599789456',
                'type' => 'suggestion',
                'details' => 'اقتراح بإضافة نشاط رياضي للطلاب',
                'status' => 'in_progress',
            ],
            [
                'complainant_name' => 'محمد خالد',
                'phone_number' => '0599234789',
                'type' => 'inquiry',
                'details' => 'استفسار عن موعد التسجيل للفصل القادم',
                'status' => 'resolved',
                'admin_reply' => 'التسجيل يبدأ يوم 1 سبتمبر',
            ],
        ];

        foreach ($complaints as $complaint) {
            Complaint::create($complaint);
        }
    }
}
