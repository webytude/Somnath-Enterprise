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
        Schema::create('firms', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('pancard')->nullable();
            $table->string('gst')->nullable();
            $table->string('pf_code')->nullable();
            $table->string('mobile_number', 20)->nullable();
            $table->string('email')->nullable();
            
            // Bank Information
            $table->string('bank_name')->nullable();
            $table->string('bank_account_no', 50)->nullable();
            $table->string('ifsc_code', 20)->nullable();
            
            // Additional Information
            $table->string('head_name')->nullable();
            $table->string('head_mobile_number', 20)->nullable();
            
            // Remarks
            $table->text('remark')->nullable();
            
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
        Schema::dropIfExists('firms');
    }
};
