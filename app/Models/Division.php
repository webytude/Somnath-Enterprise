<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'department_id', 
        'subdepartment_id',
        'head_of_division_name',
        'address',
        'head_mobile_number',
        'contact_number',
        'contact_person_name',
        'contact_person_mobile_number',
        'bank_name',
        'bank_account_no',
        'ifsc_code',
        'created_by', 
        'updated_by'
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

    // A division has many firms
    public function firms()
    {
        return $this->hasMany(Firm::class);
    }

    // A division has many sub divisions
    public function subDivisions()
    {
        return $this->hasMany(SubDivision::class);
    }
}
