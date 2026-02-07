<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'location_id',
        'date',
        'amount',
        'description',
        'remark',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    // A daily expense belongs to one staff
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    // A daily expense belongs to one location
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
