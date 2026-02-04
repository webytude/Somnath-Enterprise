<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'firm_id', 'department_id', 'subdepartment_id', 'division_id', 'sub_division_id',
        'name', 'location', 'remark', 'created_by', 'updated_by'
    ];

    // A location belongs to one firm
    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

    // A location belongs to one department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // A location belongs to one subdepartment
    public function subdepartment()
    {
        return $this->belongsTo(Subdepartment::class);
    }

    // A location belongs to one division
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // A location belongs to one sub division
    public function subDivision()
    {
        return $this->belongsTo(SubDivision::class);
    }
}
