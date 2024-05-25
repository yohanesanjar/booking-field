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
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('booking_id');
            $table->foreignId('user_id');
            $table->foreignId('payment_method_dp')->nullable();
            $table->string('account_name_dp')->nullable();
            $table->string('payment_proof_dp')->nullable();
            $table->decimal('down_payment', 10, 2)->default(0);
            $table->foreignId('payment_method_remaining')->nullable();
            $table->string('account_name_remaining')->nullable();
            $table->string('payment_proof_remaining')->nullable();
            $table->decimal('remaining_payment', 10, 2)->default(0);
            $table->timestamps();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
