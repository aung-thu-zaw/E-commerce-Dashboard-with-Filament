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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId("employee_position_id")->nullable()->constrained()->onDelete('set null');
            $table->string("image");
            $table->string("name");
            $table->string("email")->unique();
            $table->string("phone")->unique();
            $table->string("address");
            $table->string("experience");
            $table->decimal("salary", 8, 2)->default(0.00);
            $table->enum("vacation", ["sunday","monday","tuesday","wednesday","thursday","friday","saturday"])->nullable();
            $table->enum("status", ["active","inactive"])->default("active");
            $table->date("date_of_birth");
            $table->date("joining_date");
            $table->date("termination_date")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
