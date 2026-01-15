<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteMaterialRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'created_by',
        'updated_by',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function details()
    {
        return $this->hasMany(SiteMaterialRequirementDetail::class);
    }
}
