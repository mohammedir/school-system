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
        Schema::create('project_log', function (Blueprint $table) {
            $table->id();
            $table->string('action')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('user_type', ['user','investor']); // المستخدم الذي رفع الملف
            $table->unsignedBigInteger('engineering_partner_id')->nullable();
            $table->timestamps();

            $table->foreign('engineering_partner_id')->references('id')->on('engineering_partners')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_log');
    }
};
