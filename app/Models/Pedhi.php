<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedhi extends Model
{
    use HasFactory;
    protected $table = 'pedhi';
    protected $fillable = [
        'name', 'created_by', 'updated_by'
    ];
}
