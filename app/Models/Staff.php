<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'first_name',
        'last_name',
        'second_name',
        'dob',
        'doj',
        'designation',
        'photo',
        'permanent_address',
        'present_address',
        'mobile_number',
        'other_contact_number',
        'relative_name',
        'relation',
        'relative_mobile_no',
        'gender',
        'marital_status',
        'blood_group',
        'aadhar_no',
        'pan_no',
        'uan_no',
        'esic_no',
        'bank_name',
        'bank_account_no',
        'ifsc_code',
        'date_of_leaving',
        'no_of_years_service',
        'remark',
        'rate_per_day',
        'rate_per_month',
        'salary_date',
        'created_by',
        'updated_by',
    ];

    // Accessor to get full name
    public function getFullNameAttribute()
    {
        $name = trim($this->first_name . ' '. $this->second_name . ' ' . $this->last_name  );
        return $name;
    }

    protected $casts = [
        'dob' => 'date',
        'doj' => 'date',
        'date_of_leaving' => 'date',
        'salary_date' => 'date',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function dailyPayments()
    {
        return $this->hasMany(DailyPayment::class);
    }

    // A staff belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A staff has many daily expenses
    public function dailyExpenses()
    {
        return $this->hasMany(DailyExpense::class);
    }
}
