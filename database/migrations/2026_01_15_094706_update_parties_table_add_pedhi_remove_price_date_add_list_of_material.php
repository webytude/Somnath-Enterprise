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
        Schema::table('parties', function (Blueprint $table) {
            $table->foreignId('pedhi_id')->nullable()->after('name')->constrained('pedhi')->onDelete('set null');
            $table->text('list_of_material')->nullable()->after('remark');
            $table->dropColumn(['price', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parties', function (Blueprint $table) {
            $table->dropForeign(['pedhi_id']);
            $table->dropColumn(['pedhi_id', 'list_of_material']);
            $table->decimal('price', 10, 2)->nullable();
            $table->date('date')->nullable();
        });
    }
};
