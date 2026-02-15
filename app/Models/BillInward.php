<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillInward extends Model
{
    use HasFactory;

    protected $fillable = [
        'firm_id',
        'party_id',
        'party_gst',
        'party_pan',
        'bill_number',
        'bill_date',
        'bill_attachment',
        'add_bhadu_labour',
        'total_bill_amount',
        'remarks',
        'payment_status',
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
        return $this->hasMany(BillInwardDetail::class);
    }
}
