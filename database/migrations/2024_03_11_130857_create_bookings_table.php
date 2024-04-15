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
        Schema::create('bookings', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('field_data_id');
            $table->string('customer_name');
            $table->boolean('is_member')->default(false);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_subtotal', 10, 2)->nullable();
            $table->integer('booking_status')->default(-1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
