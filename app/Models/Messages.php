<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'phone',
        'message',
        'response_code',
        'response_description',
        'message_id',
        'error_details',
        'status',
    ];

    // Define relationships, if any
    public function tenant()
    {
        return $this->belongsTo(Tenants::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
