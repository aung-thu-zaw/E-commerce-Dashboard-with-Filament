<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('slug')->unique();
            $table->string('description');
            $table->enum('type', ['percentage','fixed','free_item']);
            $table->decimal('discount_amount', 8, 2)->nullable();
            $table->foreignId('free_item_id')->nullable()->constrained('products')->onDelete('set null');
            $table->decimal('minimum_order_amount', 8, 2)->nullable();
            $table->unsignedInteger('usage_limit')->nullable();
            $table->enum('validity_period', ['once', 'multiple', 'forever']);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
