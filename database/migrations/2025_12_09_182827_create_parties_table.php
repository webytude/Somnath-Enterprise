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
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gst', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_mobile', 20)->nullable();
            $table->text('remark')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('parties');
    }
};
