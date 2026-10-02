<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('block_field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerary_block_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_field_id')->constrained()->cascadeOnDelete();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('block_field_values');
    }
};
