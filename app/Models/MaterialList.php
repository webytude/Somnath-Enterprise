<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialList extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_category_id',
        'name',
        'unit',
        'remark',
        'created_by',
        'updated_by',
    ];

    // A material list belongs to one material category
    public function materialCategory()
    {
        return $this->belongsTo(MaterialCategory::class);
    }
}
