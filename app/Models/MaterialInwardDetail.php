<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialInwardDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_inward_id',
        'material_id',
        'make',
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

    public function materialInward()
    {
        return $this->belongsTo(MaterialInward::class);
    }

    public function material()
    {
        return $this->belongsTo(MaterialList::class, 'material_id');
    }
}
