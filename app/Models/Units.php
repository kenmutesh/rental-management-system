<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'property_id',
        'rentAmount',
        'occupied_by',
        'notes',
    ];



    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function unit_utilities()
    {
        return $this->hasMany(UnitUtilities::class);
    }



}
