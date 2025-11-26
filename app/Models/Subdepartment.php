<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subdepartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'department_id', 'created_by', 'updated_by'
    ];

    // A subdepartment belongs to one department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // A subdepartment has many divisions
    public function divisions()
    {
        return $this->hasMany(Division::class);
    }
}
