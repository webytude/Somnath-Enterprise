<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'firm_id',
        'department_id',
        'subdepartment_id',
        'division_id',
        'sub_division_id',
        'location_id',
        'name_of_work',
        'description_of_work',
        'tender_id',
        'estimate_cost',
        'equal_above_below_on_estimate',
        'final_amt_of_work',
        'add_18_percent_gst',
        'our_final_work_amt',
        'time_limit_years_months',
        'work_order_no',
        'wo_date',
        'end_date_of_work',
        'work_start_date',
        'if_extend_date',
        'extended_date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'estimate_cost' => 'decimal:2',
        'final_amt_of_work' => 'decimal:2',
        'add_18_percent_gst' => 'decimal:2',
        'our_final_work_amt' => 'decimal:2',
        'wo_date' => 'date',
        'end_date_of_work' => 'date',
        'work_start_date' => 'date',
        'extended_date' => 'date',
        'if_extend_date' => 'boolean',
    ];

    // Relationships
    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function subdepartment()
    {
        return $this->belongsTo(Subdepartment::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function subDivision()
    {
        return $this->belongsTo(SubDivision::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
