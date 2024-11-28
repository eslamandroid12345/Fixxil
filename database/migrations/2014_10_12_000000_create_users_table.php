<?php

use App\Http\Enums\UserType;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('type', UserType::values());
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->text('address')->nullable();
            $table->string('image')->nullable();
            $table->double('wallet')->default(0);
            $table->text('about')->nullable();
            $table->foreignId('governorate_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('city_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('zone_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('national_id')->nullable();
            $table->string('national_id_image')->nullable();
            $table->string('criminal_record_sheet')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('last_seen')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
