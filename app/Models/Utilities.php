<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilities extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'requires_reading',
        'fee_type',

    ];
}
