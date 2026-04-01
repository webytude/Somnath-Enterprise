<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->decimal('vendor_paid_total', 15, 2)->default(0)->after('total_order_value');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('work_order_id')
                ->nullable()
                ->after('vendor_id')
                ->constrained('work_orders')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['work_order_id']);
            $table->dropColumn('work_order_id');
        });

        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('vendor_paid_total');
        });
    }
};
