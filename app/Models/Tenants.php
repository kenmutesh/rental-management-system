<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenants extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'phone',
        'account_number',
        'address',
        'lease_start_date',
        'lease_end_date',
        'balance',
        'status',
    ];

    public function unit()
    {
        return $this->belongsTo(Units::class, 'id', 'occupied_by');
    }

    public function account()
    {
        return $this->hasOne(TenantAccounts::class);
    }
}
