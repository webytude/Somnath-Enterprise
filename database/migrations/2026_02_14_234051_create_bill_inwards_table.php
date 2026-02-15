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
        Schema::create('bill_inwards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firm_id')->constrained('firms')->onDelete('cascade');
            $table->foreignId('party_id')->constrained('parties')->onDelete('cascade');
            $table->string('party_gst')->nullable();
            $table->string('party_pan')->nullable();
            $table->string('bill_number')->nullable();
            $table->date('bill_date')->nullable();
            $table->string('bill_attachment')->nullable();
            $table->decimal('add_bhadu_labour', 10, 2)->default(0);
            $table->decimal('total_bill_amount', 10, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->enum('payment_status', ['Pending', 'Paid'])->default('Pending');
            $table->string('payment_ref_number')->nullable();
            $table->date('payment_date')->nullable();
            $table->text('payment_remarks')->nullable();
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
        Schema::dropIfExists('bill_inwards');
    }
};
