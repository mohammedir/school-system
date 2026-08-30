<?php

namespace Database\Seeders;

 use App\Models\Projects;
 use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        Projects::create([
            'land_id' => 1,
            'creator_investor_id' => 1,
            'title' => 'مشروع إنشاء برج سكني على أرض في حي الرمال',
            'description' => 'وصف منشئ المشروع هنا، وصف منشئ المشروع هنا، وصف منشئ المشروع هنا.',
            'project_type_cd' => 23,
            'area' => 430.00,
            'project_cost' => 165000,
            'engineering_consultant_id' => null,
            'engineering_consultant_description' => 'وصف الاستشاري الهندسي هنا، وصف الاستشاري الهندسي هنا، وصف الاستشاري الهندسي هنا.',
            'engineering_consultant_evaluation_status_cd' => 42,
            'engineering_consultant_decline_reasons' => null,
            'approved_by' => 1,
            'approval_status_cd' => 45,
            'decline_reasons' => null,
            'project_status_cd' => 53,
            'offers_start_date' => '2025-07-01',
            'offers_end_date' => '2025-07-30',
            'awarded_engineering_offer_id' => null,
            'awarded_engineering_added_by' => null,
            'awarded_engineering_date' => null,
            'awarded_engineering_reasons' => null,
            'awarded_engineering_creator_approval_cd' => null,
            'awarded_engineering_creator_approval_date' => null,
            'awarded_contractor_offer_id' => null,
            'awarded_contractor_added_by' => null,
            'awarded_contractor_date' => null,
            'awarded_contractor_reasons' => null,
        ]);
    }
}
