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
        Schema::create('students_data', function (Blueprint $table) {
            $table->id();

            // المعلومات الأساسية للطالب
            $table->string('student_id', 20)->unique()->nullable();
            $table->string('first_name', 50);
            $table->string('father_name', 50);
            $table->string('grandfather_name', 50);
            $table->string('last_name', 50);
            $table->string('full_name', 200)->virtualAs('CONCAT(first_name, " ", father_name, " ", grandfather_name, " ", last_name)');
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');

            $table->text('address')->nullable();

            // معلومات الاتصال
            $table->string('mobile', 20)->unique();
            $table->string('alternate_mobile', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();

            // معلومات ولي الأمر
            $table->string('parent_id', 20);
            $table->string('parent_name', 100);
            $table->string('parent_mobile', 20)->nullable();

            // معلومات صحية
            $table->enum('health_status', ['healthy', 'special_needs', 'chronic_disease'])->default('healthy');

            // معلومات الدراسة
            $table->date('study_start_date');
            $table->integer('initiative_id')->nullable();
            $table->integer('year_id')->nullable();
            $table->integer('section_id')->nullable();

            // معلومات إضافية
            $table->string('avatar', 255)->nullable();
            $table->text('notes')->nullable();

            // معلومات الدخول والأمان
            $table->string('password', 255)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->tinyInteger('is_authapp_enabled')->default(0)->comment('Use Authenticator App: 0 Disabled, 1 Enabled');
            $table->string('authapp_secret')->nullable()->comment('Secret of Authenticator App');

            // رموز التحقق
            $table->string('otp_code')->nullable();
            $table->timestamp('otp_code_expires_at')->nullable();

            // الحالة المالية
            $table->decimal('balance', 15, 2)->default(0);
            $table->decimal('yearly_income', 15, 2)->nullable();

            // معلومات الحالة
            $table->integer('profile_status_cd')->nullable();
            $table->integer('status_cd')->default(1);
            $table->text('rejection_reason')->nullable();
            $table->boolean('terms_accepted')->default(false)->comment('الموافقة على الشروط والأحكام');

            // صور المستندات
            $table->string('photo_personal_id', 255)->nullable();
            $table->string('photo_with_id', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // إضافة فهارس للبحث السريع
            $table->index('student_id');
            $table->index('mobile');
            $table->index('parent_id');
            $table->index('birth_date');
            $table->index('study_start_date');
            $table->index('gender');
            $table->index('health_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
