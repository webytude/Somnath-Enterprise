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
        Schema::create('gst_bill_lists', function (Blueprint $table) {
            $table->id();
            $table->string('party_name');
            $table->string('gst', 50)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->enum('is_inward_outward', ['Inward', 'Outward'])->default('Outward');
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->decimal('basic_amount', 10, 2)->default(0);
            $table->decimal('gst_amount', 10, 2)->default(0);
            $table->decimal('total_bill_amount', 10, 2)->default(0);
            $table->enum('status', ['Pending', 'Paid'])->default('Pending');
            $table->string('ref_number')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('debit_from')->nullable();
            $table->text('remark')->nullable();
            $table->enum('gst_slab', ['5', '18'])->default('18');
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
        Schema::dropIfExists('gst_bill_lists');
    }
};
