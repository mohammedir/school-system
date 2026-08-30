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
        // أضف هذا السطر لحذف الجدول إذا كان موجوداً
        Schema::dropIfExists('project_balance_log');

        Schema::create('project_balance_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->enum('user_type', ['investor','engineering_partners','contractors','staff']);
            $table->unsignedBigInteger('user_id');
            $table->Integer('transaction_type')->comment('1: Credit, 2: Debit');
            $table->decimal('amount', 15, 2)->default(0);
            $table->unsignedBigInteger('transaction_id');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_budget_log');
    }
};
