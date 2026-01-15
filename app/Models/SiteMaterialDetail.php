<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteMaterialDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_material_id',
        'material_name',
        'unit',
        'rate',
        'quantity',
        'gst',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'quantity' => 'decimal:2',
    ];

    public function siteMaterial()
    {
        return $this->belongsTo(SiteMaterial::class);
    }
}
