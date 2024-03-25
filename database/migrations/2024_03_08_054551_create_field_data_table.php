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
        Schema::create('field_data', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('field_type');
            $table->string('field_material');
            $table->string('field_location');
            $table->decimal('morning_price');
            $table->decimal('night_price');
            $table->string('thumbnail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_data');
    }
};
