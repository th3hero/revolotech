<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Returning the relationship with user for Bookings table.
     *
     * @return BelongsTo
     */
    public function Booker() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Truck() {
        return $this->belongsTo(Trucks::class, 'truck_id');
    }
}
