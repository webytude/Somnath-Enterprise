<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GstBillList extends Model
{
    use HasFactory;

    protected $fillable = [
        'party_name',
        'gst',
        'mobile',
        'is_inward_outward',
        'invoice_number',
        'invoice_date',
        'basic_amount',
        'gst_amount',
        'total_bill_amount',
        'status',
        'ref_number',
        'payment_date',
        'debit_from',
        'remark',
        'gst_slab',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'payment_date' => 'date',
        'basic_amount' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'total_bill_amount' => 'decimal:2',
    ];
}
