<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReservationSeat extends Pivot
{
    use HasFactory;
    protected $table = 'reservation_seats';
    public $timestamps = true;
    protected $fillable = [
        'seat_id',
        'reservation_id'
    ];
}
