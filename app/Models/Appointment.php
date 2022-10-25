<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doc_id',
        'appointment_status',
        'appointment_date',
        'diagnosis'
    ];

    // Relationship to Doctor
    public function doctor() {
        return $this->belongsTo(Doctor::class, 'doc_id');
    }

    // Relationship to Patient
    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    // Relationship to Medicine_bill
    public function medicine_bill() {
        return $this->hasOne(Medicine_bill::class, 'appointment_id');
    }

}
