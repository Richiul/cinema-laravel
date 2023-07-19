<?php

namespace App\Http\Controllers;

use App\Models\Auditorium;
use Illuminate\Http\Request;
use App\Http\Resources\SeatResource;
use App\Http\Resources\AuditoriumResource;
use App\Http\Controllers\API\MovieController;

class DashboardController extends Controller
{
    public $movies = [];

    public function __construct() {
        $this->movies = json_decode(MovieController::getMovies(), true);
    }
    public function index() {
    
        return view('dashboard', ['movies' => $this->movies['results']]);
    }

    public function movie() {
        return view('movie');
    }
}
