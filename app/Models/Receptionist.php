<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receptionist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'salary',
        'phone',
        'address',
        'period',
        'dateofbirth'
    ];

    // Relationship to User
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}