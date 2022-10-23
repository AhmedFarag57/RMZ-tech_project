<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeUnit\FunctionUnit;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'manufacturar',
        'price'
    ];

    // Relationship to Pharmacy
    public function pharmacy(){
        return $this->hasOne(Pharmacy::class, 'medicine_id');
    }
}