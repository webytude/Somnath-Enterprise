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
        Schema::create('material_inwards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->foreignId('work_id')->nullable()->constrained('works')->onDelete('set null');
            $table->foreignId('party_id')->constrained('parties')->onDelete('cascade');
            $table->string('party_gst')->nullable();
            $table->string('party_pan')->nullable();
            $table->string('bill_voucher_type')->nullable();
            $table->string('bill_voucher_number')->nullable();
            $table->date('bill_voucher_date')->nullable();
            $table->date('material_inward_at_site_date')->nullable();
            $table->string('bill_voucher_attachment')->nullable();
            $table->decimal('add_bhadu', 10, 2)->default(0);
            $table->decimal('total_bill_voucher_amount', 10, 2)->default(0);
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
        Schema::dropIfExists('material_inwards');
    }
};
