<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_address',
        'notes',
        'attachment', 
        'user_id',
        'status',
        'total_amount',
    ];
}

