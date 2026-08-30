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
        Schema::create('registrations_students', function (Blueprint $table) {
            $table->id();

            // معلومات الطالب
            $table->string('student_id_number')->unique(); // رقم هوية الطالب
            $table->string('student_full_name'); // اسم الطالب رباعي
            $table->date('birth_date'); // تاريخ الميلاد
            $table->string('address'); // عنوان السكن

            // معلومات المرحلة والفصل
            $table->unsignedBigInteger('age_group_id'); // المرحلة الدراسية
            $table->unsignedBigInteger('class_id'); // الفصل

            // معلومات ولي الأمر
            $table->string('guardian_name'); // اسم ولي الأمر
            $table->string('guardian_id_number'); // رقم هوية ولي الأمر
            $table->string('phone_number'); // رقم الهاتف
            $table->string('transfer_notice')->nullable(); // إشعار التحويل (مسار الملف)

            // ملاحظات إضافية
            $table->text('additional_notes')->nullable();

            // حالة الطلب
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');

            $table->timestamps();

            // إضافة فهارس
            $table->index('student_id_number');
            $table->index('phone_number');
            $table->index('status');
            $table->index('age_group_id');
            $table->index('class_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations_students');
    }
};
