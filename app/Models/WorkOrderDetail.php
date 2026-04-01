<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id',
        'sort_order',
        'work_details',
        'quantity',
        'unit',
        'rate',
        'amount',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'rate' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
