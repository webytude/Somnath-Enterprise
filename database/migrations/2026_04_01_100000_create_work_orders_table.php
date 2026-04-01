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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('work_order_number')->unique();
            $table->string('fiscal_year_label', 16);
            $table->unsignedInteger('sequence_number');
            $table->date('order_date');
            $table->foreignId('contractor_id')->constrained('contractors')->onDelete('cascade');
            $table->text('subject')->nullable();
            $table->text('condition_text')->nullable();
            $table->decimal('total_order_value', 15, 2)->default(0);
            $table->text('time_limit_for_work')->nullable();
            $table->text('payment_condition')->nullable();
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->foreignId('work_id')->nullable()->constrained('works')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['fiscal_year_label', 'sequence_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
