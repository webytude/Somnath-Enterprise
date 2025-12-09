<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScrapMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'date' => 'date',
    ];

    public function scrapLists()
    {
        return $this->hasMany(ScrapList::class, 'material_id');
    }
}
