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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('payment_type', ['staff', 'party', 'vendor'])->default('staff');
            
            // Foreign keys (nullable based on payment type)
            $table->foreignId('staff_id')->nullable()->constrained('staff')->onDelete('cascade');
            $table->foreignId('party_id')->nullable()->constrained('parties')->onDelete('cascade');
            $table->foreignId('vendor_id')->nullable()->constrained('contractors')->onDelete('cascade');
            
            // Staff payment fields
            $table->decimal('salary_payable', 10, 2)->nullable()->default(0);
            $table->decimal('expense_payable', 10, 2)->nullable()->default(0);
            $table->decimal('total_payable', 10, 2)->nullable()->default(0);
            $table->string('reason_of_payment')->nullable();
            
            // Party/Vendor payment fields
            $table->string('reason_bill_no')->nullable();
            $table->decimal('bill_payable', 10, 2)->nullable()->default(0);
            
            // Payment information (common for all types)
            $table->decimal('amount_payable', 10, 2)->default(0);
            $table->decimal('tds_percentage', 5, 2)->nullable()->default(0);
            $table->decimal('total_deduction', 10, 2)->nullable()->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->string('ref_number')->nullable();
            $table->date('payment_date');
            $table->text('remarks')->nullable();
            
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
        Schema::dropIfExists('payments');
    }
};
