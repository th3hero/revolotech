<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(mixed $id)
 */
class Trucks extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'total_capacity',
        'manufacturing_year',
        'available_from_date',
        'available_to_date',
        'available_for_book',
        'available_capacity'
    ];
}
