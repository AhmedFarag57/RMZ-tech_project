<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'quantity'
    ];

    // Relationship to Medicine
    public function medicine(){
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }
}