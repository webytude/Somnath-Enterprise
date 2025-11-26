<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'created_by', 'updated_by'
    ];

    // A department has many subdepartments
    public function subdepartments()
    {
        return $this->hasMany(Subdepartment::class);
    }

    // A department has many divisions (via subdepartments, or directly if needed)
    public function divisions()
    {
        return $this->hasManyThrough(Division::class, Subdepartment::class);
    }
}
