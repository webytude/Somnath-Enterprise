<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillOutward extends Model
{
    use HasFactory;

    protected $fillable = [
        'firm_id',
        'firm_gst',
        'bill_number',
        'bill_date',
        'bill_attachment',
        'party_id',
        'party_gst',
        'party_address',
        'add_bhadu_labour',
        'total_bill_amount',
        'remarks',
        'payment_status',
        'sd_percentage',
        'tds_percentage',
        'gst_deduction_percentage',
        'lc_percentage',
        'tc_percentage',
        'total_deduction',
        'net_received_amount',
        'payment_ref_number',
        'payment_date',
        'payment_remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'bill_date' => 'date',
        'payment_date' => 'date',
        'add_bhadu_labour' => 'decimal:2',
        'total_bill_amount' => 'decimal:2',
        'sd_percentage' => 'decimal:2',
        'tds_percentage' => 'decimal:2',
        'gst_deduction_percentage' => 'decimal:2',
        'lc_percentage' => 'decimal:2',
        'tc_percentage' => 'decimal:2',
        'total_deduction' => 'decimal:2',
        'net_received_amount' => 'decimal:2',
    ];

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function details()
    {
        return $this->hasMany(BillOutwardDetail::class);
    }
}
