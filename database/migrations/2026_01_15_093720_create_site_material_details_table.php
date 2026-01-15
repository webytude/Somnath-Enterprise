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
        Schema::create('site_material_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_material_id')->constrained('site_materials')->onDelete('cascade');
            $table->string('material_name');
            $table->string('unit');
            $table->decimal('rate', 10, 2);
            $table->decimal('quantity', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_material_details');
    }
};
