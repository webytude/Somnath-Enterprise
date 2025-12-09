<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gst',
        'address',
        'mobile',
        'contact_person_name',
        'contact_person_mobile',
        'remark',
        'price',
        'date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'date' => 'date',
    ];
}
