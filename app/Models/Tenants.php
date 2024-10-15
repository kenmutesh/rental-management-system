<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenants extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'lease_start_date',
        'lease_end_date',
        'balance',
        'status',
    ];
}
