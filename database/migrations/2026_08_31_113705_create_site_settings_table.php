<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            // 1. الهوية البصرية والنصوص الرئيسية (Tab 1)
            $table->string('site_logo')->nullable()->comment('مسار شعار المدرسة');
            $table->string('site_name')->default('مدرسة ليرن تو بي (Learn To Be)')->comment('اسم المدرسة');
            $table->string('hero_title')->nullable()->comment('عنوان الواجهة الرئيسية');
            $table->text('hero_subtitle')->nullable()->comment('وصف الواجهة الرئيسية');

            // 2. الرؤية والرسالة وكلمة المديرة (Tab 2)
            $table->text('school_vision')->nullable()->comment('رؤية المدرسة');
            $table->text('school_mission')->nullable()->comment('رسالة المدرسة');
            $table->string('principal_name')->nullable()->comment('اسم المديرة');
            $table->string('principal_image')->nullable()->comment('مسار صورة المديرة');
            $table->longText('principal_speech')->nullable()->comment('نص كلمة المديرة');

            // 3. الأقسام التعليمية (Tab 3)
            $table->text('section_kindergarten')->nullable()->comment('وصف قسم الروضة والتمهيدي');
            $table->text('section_primary')->nullable()->comment('وصف المرحلة الأساسية');
            $table->text('section_secondary')->nullable()->comment('وصف المرحلة الإعدادية/الثانوية');
            $table->text('section_center')->nullable()->comment('وصف مركز الدورات والأنشطة');

            // 4. معلومات الاتصال والتواصل الاجتماعي (Tab 4)
            $table->string('contact_phone')->nullable()->comment('رقم الهاتف الرئيسية');
            $table->string('contact_whatsapp')->nullable()->comment('رقم الواتساب');
            $table->string('contact_email')->nullable()->comment('البريد الإلكتروني');
            $table->string('contact_address')->nullable()->comment('العنوان');
            $table->string('social_facebook')->nullable()->comment('رابط فيسبوك');
            $table->string('social_instagram')->nullable()->comment('رابط انستغرام');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
