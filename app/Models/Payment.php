<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_type',
        'staff_id',
        'party_id',
        'vendor_id',
        'salary_payable',
        'expense_payable',
        'total_payable',
        'reason_of_payment',
        'reason_bill_no',
        'bill_payable',
        'amount_payable',
        'tds_percentage',
        'total_deduction',
        'paid_amount',
        'ref_number',
        'payment_date',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'salary_payable' => 'decimal:2',
        'expense_payable' => 'decimal:2',
        'total_payable' => 'decimal:2',
        'bill_payable' => 'decimal:2',
        'amount_payable' => 'decimal:2',
        'tds_percentage' => 'decimal:2',
        'total_deduction' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Contractor::class, 'vendor_id');
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
