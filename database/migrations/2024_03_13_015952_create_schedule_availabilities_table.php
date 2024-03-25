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
        Schema::create('schedule_availabilities', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id');
            $table->date('schedule_date');
            $table->foreignId('field_data_id');
            $table->foreignId('field_schedule_id');
            $table->boolean('is_available');
            $table->timestamps();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_availabilities');
    }
};
