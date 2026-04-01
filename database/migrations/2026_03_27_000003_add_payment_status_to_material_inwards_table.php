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
        Schema::table('material_inwards', function (Blueprint $table) {
            if (!Schema::hasColumn('material_inwards', 'payment_status')) {
                $table->enum('payment_status', ['Pending', 'Paid'])->default('Pending')->after('total_bill_voucher_amount');
            }

            if (!Schema::hasColumn('material_inwards', 'payment_ref_number')) {
                $table->string('payment_ref_number')->nullable()->after('payment_status');
            }

            if (!Schema::hasColumn('material_inwards', 'payment_date')) {
                $table->date('payment_date')->nullable()->after('payment_ref_number');
            }

            if (!Schema::hasColumn('material_inwards', 'payment_remarks')) {
                $table->text('payment_remarks')->nullable()->after('payment_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material_inwards', function (Blueprint $table) {
            $dropColumns = [];

            if (Schema::hasColumn('material_inwards', 'payment_status')) {
                $dropColumns[] = 'payment_status';
            }

            if (Schema::hasColumn('material_inwards', 'payment_ref_number')) {
                $dropColumns[] = 'payment_ref_number';
            }

            if (Schema::hasColumn('material_inwards', 'payment_date')) {
                $dropColumns[] = 'payment_date';
            }

            if (Schema::hasColumn('material_inwards', 'payment_remarks')) {
                $dropColumns[] = 'payment_remarks';
            }

            if (!empty($dropColumns)) {
                $table->dropColumn($dropColumns);
            }
        });
    }
};
