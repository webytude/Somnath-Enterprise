<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'firm_id',
        'gst',
        'pancard',
        'address',
        'mobile',
        'contact_person_name',
        'contact_person_mobile',
        'remark',
        'list_of_material',
        'bank_account_holder_name',
        'bank_name_branch',
        'bank_account_no',
        'ifsc_code',
        'created_by',
        'updated_by',
    ];

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

    // Many-to-many relationship with materials
    public function materials()
    {
        return $this->belongsToMany(MaterialList::class, 'party_materials', 'party_id', 'material_list_id');
    }

    // Many-to-many relationship with locations
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'party_locations', 'party_id', 'location_id');
    }
}
