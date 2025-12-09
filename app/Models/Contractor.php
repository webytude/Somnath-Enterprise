<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contractor extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedhi',
        'gst',
        'pan',
        'bank_name',
        'ifsc',
        'branch_name',
        'address',
        'mobile',
        'contact_person',
        'contact_person_mobile',
        'ref_by',
        'payment_term',
        'amount',
        'remaining_amount',
        'payment_slab_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    public function paymentSlab()
    {
        return $this->belongsTo(PaymentSlab::class);
    }
}
