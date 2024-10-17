<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitUtilities extends Model
{
    use HasFactory;

    protected $fillable = [
            "utility_id",
            "unit_id",
    ];
}
