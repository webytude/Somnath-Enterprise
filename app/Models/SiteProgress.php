<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'work_id',
        'work_name',
        'work_site',
        'work_stage',
        'stage_id',
        'stage_percentage',
        'remark',
        'photo_url',
        'date',
        'created_by',
        'updated_by',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    protected $casts = [
        'date' => 'date',
        'stage_percentage' => 'decimal:2',
    ];
}
