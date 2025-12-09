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
        Schema::create('scrap_lists', function (Blueprint $table) {
            $table->id();
            $table->string('feriya')->nullable();
            $table->date('date');
            $table->string('unit')->nullable();
            $table->decimal('quantity', 10, 2)->default(0);
            $table->string('where_place')->nullable();
            $table->string('labour_of_scrape')->nullable();
            $table->text('remark')->nullable();
            $table->foreignId('material_id')->nullable()->constrained('scrap_materials')->onDelete('set null');
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
        Schema::dropIfExists('scrap_lists');
    }
};
