<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'propertyName',
        'totalUnits',
        'city',
        'waterRate',
        'electricityRate',
        'penaltyPercentage',
        'streetName',
        'paymentUnstructions',
        'invoicingDay',
        'smsReminderDay'
    ];



    public function units()
    {
        return $this->hasMany(Units::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'property_user');
    }

    // In Property.php
    public function tenants()
    {
        return $this->hasManyThrough(Tenants::class, Units::class, 'property_id', 'id', 'id', 'occupied_by');
    }
}
