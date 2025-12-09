<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ToolList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'location',
        'price',
        'remark',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'price' => 'decimal:2',
    ];
}
