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
        Schema::create('uses', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('video_link')->nullable();
            $table->longtext('description_en')->nullable();
            $table->longtext('description_ar')->nullable();
            $table->foreignId('use_category_id')->nullable()
                ->constrained('use_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()
                ->constrained('uses')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uses');
    }
};
