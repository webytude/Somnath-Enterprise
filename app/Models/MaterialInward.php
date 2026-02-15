<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialInward extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'work_id',
        'party_id',
        'party_gst',
        'party_pan',
        'bill_voucher_type',
        'bill_voucher_number',
        'bill_voucher_date',
        'material_inward_at_site_date',
        'bill_voucher_attachment',
        'add_bhadu',
        'total_bill_voucher_amount',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'bill_voucher_date' => 'date',
        'material_inward_at_site_date' => 'date',
        'add_bhadu' => 'decimal:2',
        'total_bill_voucher_amount' => 'decimal:2',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function details()
    {
        return $this->hasMany(MaterialInwardDetail::class);
    }
}
