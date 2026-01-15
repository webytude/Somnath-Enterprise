<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteMaterialRequirementDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_material_requirement_id',
        'material_name',
        'unit',
        'rate',
        'quantity',
        'date',
        'remark',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'quantity' => 'decimal:2',
        'date' => 'date',
    ];

    public function siteMaterialRequirement()
    {
        return $this->belongsTo(SiteMaterialRequirement::class);
    }
}
