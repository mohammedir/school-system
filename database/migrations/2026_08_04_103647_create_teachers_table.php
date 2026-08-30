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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            // معلومات المدرس الأساسية
            $table->string('teacher_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number')->unique();
            $table->string('national_id')->unique()->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();

            // معلومات العنوان
            $table->string('address')->nullable();
            $table->foreignId('province_id')->nullable()->constrained('lookups')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('lookups')->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained('lookups')->nullOnDelete();

            // المعلومات المهنية
            $table->foreignId('age_group_id')->nullable()->constrained('lookups')->nullOnDelete(); // المرحلة الدراسية
            $table->text('specializations')->nullable(); // التخصصات
            $table->integer('experience_years')->nullable();
            $table->text('qualifications')->nullable(); // المؤهلات العلمية
            $table->text('certificates')->nullable(); // الشهادات
            $table->text('previous_experience')->nullable(); // الخبرات السابقة

            // الملفات
            $table->string('profile_image')->nullable();
            $table->string('cv_file')->nullable(); // السيرة الذاتية
            $table->string('certificates_file')->nullable(); // شهادات
            $table->string('id_photo')->nullable(); // صورة الهوية
            $table->string('certificate_good_conduct')->nullable(); // صورة الهوية

            // حالة المدرس
            $table->enum('status', ['pending', 'active', 'inactive', 'suspended'])
                ->default('pending');

            // توفر المدرس
            $table->enum('availability', ['full_time', 'part_time', 'freelance'])
                ->nullable();

            // ملاحظات
            $table->text('notes')->nullable();

            // تواريخ
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // فهارس
            $table->index(['age_group_id', 'status']);
            $table->index('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
