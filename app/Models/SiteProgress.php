<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_name',
        'work_site',
        'remark',
        'photo_url',
        'date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
