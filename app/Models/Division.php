<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'department_id', 'subdepartment_id', 'created_by', 'updated_by'
    ];

    // A division belongs to one department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // A division belongs to one subdepartment
    public function subdepartment()
    {
        return $this->belongsTo(Subdepartment::class);
    }

    // A division has many pedhi
    public function pedhi()
    {
        return $this->hasMany(Pedhi::class);
    }
}
