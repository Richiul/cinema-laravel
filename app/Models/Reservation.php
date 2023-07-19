<?php

namespace App\Models;

use App\Models\Seat;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'movie_id', 'auditorium', 'time'];
    public $timestamps = true;
    
    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'reservation_seats');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
