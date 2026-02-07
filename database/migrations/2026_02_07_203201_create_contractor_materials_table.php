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
        Schema::create('contractor_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contractor_id')->constrained()->onDelete('cascade');
            $table->foreignId('material_list_id')->constrained('material_lists')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['contractor_id', 'material_list_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractor_materials');
    }
};
