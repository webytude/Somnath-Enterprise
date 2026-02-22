<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'percentage',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'percentage' => 'decimal:2',
    ];
}
