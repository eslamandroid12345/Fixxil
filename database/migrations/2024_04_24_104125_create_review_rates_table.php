<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('review_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->nullable()->constrained('reviews')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('question_id')->nullable()->constrained('questions')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->float('rate')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_rates');
    }
};
