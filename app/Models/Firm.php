<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Firm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'pancard',
        'gst',
        'pf_code',
        'mobile_number',
        'email',
        'bank_name',
        'bank_account_no',
        'ifsc_code',
        'head_name',
        'head_mobile_number',
        'remark',
        'created_by',
        'updated_by',
    ];
}
