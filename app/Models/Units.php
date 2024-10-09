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
        'notes',
    ];



    public function property()
    {
        return $this->belongsTo(Property::class);
    }


}
