<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubDivision extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'division_id',
        'head_of_sub_division',
        'address',
        'name_of_sub_div_head',
        'head_mobile_number',
        'sub_div_contact_person_name',
        'contact_person_name',
        'contact_person_mobile_number',
        'remark',
        'created_by', 
        'updated_by'
    ];

    // A sub division belongs to one division
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
