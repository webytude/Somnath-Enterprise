<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedhi extends Model
{
    use HasFactory;
    protected $table = 'pedhi';
    protected $fillable = [
        'name', 'department_id', 'subdepartment_id', 'division_id', 'created_by', 'updated_by'
    ];

    // A pedhi belongs to one department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // A pedhi belongs to one subdepartment
    public function subdepartment()
    {
        return $this->belongsTo(Subdepartment::class);
    }

    // A pedhi belongs to one division
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
