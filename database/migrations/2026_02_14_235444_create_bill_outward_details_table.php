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
        Schema::create('bill_outward_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_outward_id')->constrained('bill_outwards')->onDelete('cascade');
            $table->foreignId('material_id')->nullable()->constrained('material_lists')->onDelete('cascade');
            $table->foreignId('work_id')->nullable()->constrained('works')->onDelete('cascade');
            $table->decimal('quantity', 10, 2)->default(0);
            $table->string('unit')->nullable();
            $table->decimal('rate', 10, 2)->default(0);
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('gst_percentage', 5, 2)->default(0);
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_outward_details');
    }
};
