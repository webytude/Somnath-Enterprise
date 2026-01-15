<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'party_id',
        'gst',
        'name',
        'photo',
        'quantity',
        'is_inward',
        'remark',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'is_inward' => 'boolean',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function details()
    {
        return $this->hasMany(SiteMaterialDetail::class);
    }
}
