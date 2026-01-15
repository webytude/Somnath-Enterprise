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
        Schema::create('site_material_requirement_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_material_requirement_id');
            $table->string('material_name');
            $table->string('unit');
            $table->decimal('rate', 10, 2);
            $table->decimal('quantity', 10, 2);
            $table->date('date');
            $table->text('remark')->nullable();
            $table->timestamps();
            
            $table->foreign('site_material_requirement_id', 'smr_details_smr_id_fk')
                  ->references('id')
                  ->on('site_material_requirements')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_material_requirement_details', function (Blueprint $table) {
            $table->dropForeign('smr_details_smr_id_fk');
        });
        Schema::dropIfExists('site_material_requirement_details');
    }
};
