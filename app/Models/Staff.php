<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'father_name',
        'dob',
        'doj',
        'designation',
        'photo',
        'permanent_address',
        'present_address',
        'mobile_number',
        'gender',
        'marital_status',
        'blood_group',
        'nominee_name',
        'nominee_relation',
        'aadhar_no',
        'pan_no',
        'uan_no',
        'esic_no',
        'bank_name',
        'bank_account_no',
        'date_of_leaving',
        'no_of_years_service',
        'remark',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'dob' => 'date',
        'doj' => 'date',
        'date_of_leaving' => 'date',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function dailyPayments()
    {
        return $this->hasMany(DailyPayment::class);
    }
}
