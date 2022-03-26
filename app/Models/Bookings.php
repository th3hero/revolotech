<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'truck_id',
        'company_name',
        'booking_date',
        'booking_weight',
        'booked_from',
        'delivery_to'
    ];
}
