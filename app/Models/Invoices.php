<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'unit_id',
        'amount',
        'invoice_month',
        'invoice_year'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenants::class);
    }

    public function unit()
    {
        return $this->belongsTo(Units::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
