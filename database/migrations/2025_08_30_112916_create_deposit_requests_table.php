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
        Schema::create('deposit_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('user_type', ['investor','teacher','contractor','staff']);
            $table->unsignedBigInteger('user_id');
            $table->integer('amount');
            $table->date('payment_date');
            $table->integer('payment_method_cd');
            $table->string('payment_proof');
            $table->string('bank_name')->nullable();
            $table->text('payment_notes')->nullable();
            $table->text('reference_number')->nullable();
            $table->string('deposit_request_status_cd'); // pending, approved, rejected
            $table->text('admin_notes')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_requests');
    }
};
