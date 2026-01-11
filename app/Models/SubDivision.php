<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubDivision extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'division_id', 'created_by', 'updated_by'
    ];

    // A sub division belongs to one division
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
