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
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId("employee_id")->constrained()->cascadeOnDelete();
            $table->enum("type", ["monthly","hourly"])->default("monthly");
            $table->decimal("amount", 8, 2)->default(0.00);
            $table->date("effective_date");
            $table->date("termination_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_salaries');
    }
};
