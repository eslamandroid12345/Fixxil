<?php

use App\Http\Enums\OrderAction;
use App\Http\Enums\OrderNegotiateStatus;
use App\Http\Enums\OrderStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('provider_id')->nullable()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('status', OrderStatus::values());
            $table->enum('action', OrderAction::values())->nullable();
            $table->enum('negotiate_status', OrderNegotiateStatus::values())->nullable();
            $table->timestamp('at')->nullable();
            $table->float('price')->unsigned()->nullable();
            $table->boolean('has_discount_before')->default(false);
            $table->foreignId('sub_category_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('city_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('zone_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('address');
            $table->text('description');
            $table->integer('point_counter')->default(0);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
