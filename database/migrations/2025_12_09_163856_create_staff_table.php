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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->date('dob')->nullable();
            $table->date('doj')->nullable();
            $table->string('designation')->nullable();
            $table->string('photo')->nullable();
            $table->text('permanent_address')->nullable();
            $table->text('present_address')->nullable();
            $table->string('mobile_number', 20)->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed'])->nullable();
            $table->string('blood_group', 10)->nullable();
            $table->string('nominee_name')->nullable();
            $table->string('nominee_relation')->nullable();
            $table->string('aadhar_no', 20)->nullable();
            $table->string('pan_no', 20)->nullable();
            $table->string('uan_no', 50)->nullable();
            $table->string('esic_no', 50)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_no', 50)->nullable();
            $table->date('date_of_leaving')->nullable();
            $table->integer('no_of_years_service')->nullable();
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
        Schema::dropIfExists('staff');
    }
};
