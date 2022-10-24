<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    // Relationship to Doctor
    public function doctor(){
        return $this->hasMany(Doctor::class, 'dep_id');
    }
}
