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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complainant_name'); // اسم المشتكي
            $table->string('phone_number', 20); // رقم التواصل
            $table->enum('type', ['complaint', 'suggestion', 'inquiry'])->default('complaint'); // نوع الشكوى
            $table->text('details'); // التفاصيل
            $table->enum('status', ['pending', 'in_progress', 'resolved', 'rejected'])->default('pending'); // حالة الشكوى (اختياري)
            $table->text('admin_reply')->nullable(); // رد الإدارة (اختياري)
            $table->timestamps(); // created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
