<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillInwardDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_inward_id',
        'material_id',
        'quantity',
        'unit',
        'rate',
        'amount',
        'gst_percentage',
        'sub_total',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'rate' => 'decimal:2',
        'amount' => 'decimal:2',
        'gst_percentage' => 'decimal:2',
        'sub_total' => 'decimal:2',
    ];

    public function billInward()
    {
        return $this->belongsTo(BillInward::class);
    }

    public function material()
    {
        return $this->belongsTo(MaterialList::class, 'material_id');
    }
}
