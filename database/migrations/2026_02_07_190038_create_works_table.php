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
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firm_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->foreignId('subdepartment_id')->constrained()->onDelete('cascade');
            $table->foreignId('division_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_division_id')->nullable()->constrained('sub_divisions')->onDelete('cascade');
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->string('name_of_work');
            $table->text('description_of_work')->nullable();
            $table->string('tender_id')->nullable();
            $table->decimal('estimate_cost', 15, 2)->nullable();
            $table->enum('equal_above_below_on_estimate', ['0', '+', '-'])->nullable();
            $table->decimal('final_amt_of_work', 15, 2)->nullable();
            $table->decimal('add_18_percent_gst', 15, 2)->nullable();
            $table->decimal('our_final_work_amt', 15, 2)->nullable();
            $table->string('time_limit_years_months')->nullable(); // Format: "2-6" for 2 years 6 months
            $table->string('work_order_no')->nullable();
            $table->date('wo_date')->nullable();
            $table->date('end_date_of_work')->nullable();
            $table->date('work_start_date')->nullable();
            $table->boolean('if_extend_date')->default(false);
            $table->date('extended_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
