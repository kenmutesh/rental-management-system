<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoices_id',
        'description',
        'amount',
    ];


    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'invoice_id');
    }
}
