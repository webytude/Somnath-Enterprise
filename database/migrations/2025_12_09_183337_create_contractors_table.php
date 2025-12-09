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
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->string('pedhi')->nullable();
            $table->string('gst', 50)->nullable();
            $table->string('pan', 20)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ifsc', 20)->nullable();
            $table->string('branch_name')->nullable();
            $table->text('address')->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_person_mobile', 20)->nullable();
            $table->string('ref_by')->nullable();
            $table->string('payment_term')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('remaining_amount', 10, 2)->nullable();
            $table->foreignId('payment_slab_id')->nullable()->constrained('payment_slabs')->onDelete('set null');
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
        Schema::dropIfExists('contractors');
    }
};
