<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteMaterialRequirementDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_material_requirement_id',
        'material_id',
        'unit',
        'quantity',
        'date',
        'time_within_days',
        'remark',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'date' => 'date',
    ];

    public function siteMaterialRequirement()
    {
        return $this->belongsTo(SiteMaterialRequirement::class);
    }

    public function material()
    {
        return $this->belongsTo(\App\Models\MaterialList::class, 'material_id');
    }
}
