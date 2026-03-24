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
        Schema::create('waste_submission_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('waste_submission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('waste_category_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 8, 2);
            $table->decimal('points_per_unit', 10, 2);
            $table->integer('subtotal_points');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_submission_items');
    }
};
