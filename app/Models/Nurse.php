<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'address',
        'phone',
        'salary',
        'dateofbirth',
        'period'
    ];

    // Relationship to
}