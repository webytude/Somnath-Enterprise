<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScrapList extends Model
{
    use HasFactory;

    protected $fillable = [
        'feriya',
        'date',
        'unit',
        'quantity',
        'where_place',
        'labour_of_scrape',
        'remark',
        'material_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date' => 'date',
        'quantity' => 'decimal:2',
    ];

    public function material()
    {
        return $this->belongsTo(ScrapMaterial::class, 'material_id');
    }
}
