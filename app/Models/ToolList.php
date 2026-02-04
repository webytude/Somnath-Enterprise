<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ToolList extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'name',
        'quantity',
        'person_name',
        'date',
        'price',
        'remark',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'price' => 'decimal:2',
        'date' => 'date',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
