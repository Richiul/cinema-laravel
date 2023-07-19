<?php

namespace App\Http\Controllers\API;

use App\Models\Seat;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\ReservationSeat;
use App\Http\Controllers\Controller;
use App\Http\Resources\SeatResource;
use Illuminate\Support\Facades\Auth;

class SeatController extends Controller
{
    public function index()
    {
        return SeatResource::make(Seat::all());
    }

    public function store(Request $request) 
    {
        $seats = $request->seats;   
        $movieId = $request->movieId;
        $auditorium = $request->auditorium;
        $timeframe = $request->timeframe;

        $reservation = Reservation::firstOrCreate([
            'user_id' => 1,
            'movie_id' => $movieId,
            'auditorium' => $auditorium,
            'time' => $timeframe
        ]);

        if(!$reservation->wasRecentlyCreated) {
            return response()->json(['message' => 'You already have a reservation for this movie!']);
        }
        foreach($seats as $seat) {

            $row = $seat['row'];
            $col = $seat['col'];

            $db_seat = Seat::where('row', $row)->where('column', $col)->first();

            if($db_seat) {
                $reservation->seats()->syncWithoutDetaching($db_seat);
            }
        }

        return response()->json(['message' => 'Successfully reserved seat!']);
    }

    public function reservedSeats(Request $request) 
    {
        
        $movieId = $request->id;
        $reservation = Reservation::where('user_id', 1)->where('movie_id', $movieId)->first();
        $response = [];
        if($reservation)
        {
            foreach($reservation->seats as $reservedSeats) {
                $response[] = $reservedSeats;
            }
            
        }
        return response()->json(['reservedSeats' => $response]);
    }
}
