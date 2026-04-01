<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class WorkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_number',
        'number_prefix',
        'fiscal_year_label',
        'sequence_number',
        'order_date',
        'contractor_id',
        'subject',
        'condition_text',
        'total_order_value',
        'vendor_paid_total',
        'time_limit_for_work',
        'payment_condition',
        'location_id',
        'work_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'order_date' => 'date',
        'total_order_value' => 'decimal:2',
        'vendor_paid_total' => 'decimal:2',
    ];

    /**
     * Sum of vendor payment "Amt. (Payable)" lines posted against this work order.
     */
    public function syncVendorPaidTotalFromPayments(): void
    {
        $sum = Payment::query()
            ->where('payment_type', 'vendor')
            ->where('work_order_id', $this->id)
            ->sum('amount_payable');
        $this->forceFill(['vendor_paid_total' => $sum])->save();
    }

    public function vendorRemainingPayableExcludingPayment(?int $excludePaymentId = null): float
    {
        $q = Payment::query()
            ->where('payment_type', 'vendor')
            ->where('work_order_id', $this->id);
        if ($excludePaymentId) {
            $q->where('id', '!=', $excludePaymentId);
        }
        $paid = (float) $q->sum('amount_payable');

        return round(max(0, (float) $this->total_order_value - $paid), 2);
    }

    public function paymentSelectLabel(): string
    {
        $base = $this->work_order_number ?? '';
        $subject = $this->subject ? trim(preg_replace('/\s+/', ' ', $this->subject)) : '';
        if ($subject !== '') {
            $base .= '-' . Str::limit($subject, 80, '…');
        }

        return $base;
    }

    public function vendorPayments()
    {
        return $this->hasMany(Payment::class, 'work_order_id')
            ->where('payment_type', 'vendor')
            ->orderByDesc('payment_date');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function details()
    {
        return $this->hasMany(WorkOrderDetail::class)->orderBy('sort_order');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
