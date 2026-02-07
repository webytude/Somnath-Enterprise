<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contractor extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedhi',
        'gst',
        'pan',
        'bank_name',
        'ifsc',
        'branch_name',
        'bank_account_no',
        'address',
        'mobile',
        'contact_person',
        'contact_person_mobile',
        'ref_by',
        'ref_cont_no',
        'payment_term',
        'amount',
        'remaining_amount',
        'payment_slab_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    public function paymentSlab()
    {
        return $this->belongsTo(PaymentSlab::class);
    }

    // Many-to-many relationship with materials
    public function materials()
    {
        return $this->belongsToMany(MaterialList::class, 'contractor_materials', 'contractor_id', 'material_list_id');
    }

    // Many-to-many relationship with locations
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'contractor_locations', 'contractor_id', 'location_id');
    }
}
