<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tenants extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'first_name','last_name','email','phone','id_number','kra_pin','employer_name','job_title',
        'monthly_income','property_id','unit_id','lease_start_date','rent_amount','security_deposit','advance_rent',
        'payment_method','apply_discount','discount_type','discount_value','emergency_contact_name','emergency_contact_phone',
        'notes','account_number','address','gender','date_of_birth','marital_status','city','county','postal_code',
        'emergency_contact_relationship',
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
