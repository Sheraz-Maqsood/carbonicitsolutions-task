<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Weather extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'city',
        'location',
        'temperature',
        'description',
    ];
}
