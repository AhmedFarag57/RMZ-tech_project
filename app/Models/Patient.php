<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ssn',
        'gender',
        'address',
        'phone',
        'dateofbirth'
    ];

    // Relationship to Prescription
    public function prescription(){
        return $this->hasMany(Prescription::class, 'patient_id');
    }

    // Relationship to Appointment
    public function appointment(){
        return $this->hasMany(Appointment::class, 'patient_id');
    }
}