<?php

namespace App\Http\Controllers\API;

use App\Models\Auditorium;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class MovieController extends Controller
{
    public function index(Request $request)
    {
        $movieId = $request->id;

        return $this->getMovie($movieId);
    }

    public function getMovie($id) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.themoviedb.org/3/movie/' . $id . '?api_key=' . env('MOVIE_DB_API_KEY') . '&language=en-US',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($curl);

        curl_close($curl);
        
        return $response;
    }

    public static function getMovies() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.themoviedb.org/3/trending/all/day?api_key=' . env('MOVIE_DB_API_KEY'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_VERBOSE => true
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($curl);
        
        curl_close($curl);

        return $response;
    }

    public function getAuditoriumMovieMap() {

        $auditoriums = Auditorium::select('name')->get();
        $movies = json_decode(self::getMovies(), true);
        
        $movie_auditorium_map = [];
        foreach($movies['results'] as $key => $movie) {

            $movie_auditorium_map[$movie['id']] = $auditoriums[$key]->name;
        }

        return $movie_auditorium_map;

    }
}
