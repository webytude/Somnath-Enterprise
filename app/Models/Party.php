<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pedhi_id',
        'gst',
        'address',
        'mobile',
        'contact_person_name',
        'contact_person_mobile',
        'remark',
        'list_of_material',
        'created_by',
        'updated_by',
    ];

    public function pedhi()
    {
        return $this->belongsTo(Pedhi::class);
    }
}
