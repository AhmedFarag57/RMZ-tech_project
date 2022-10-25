<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine_bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'medicines_id',
        'total'
    ];

    // Relationship to Appointment
    public function appointment() {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
}
