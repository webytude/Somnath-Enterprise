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
        'location_id',
        'work_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'percentage' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
