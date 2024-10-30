<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    //
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function showWeather(Request $request)
    {
        $city = $request->input('city', 'Lahore');

        // I am trying to fetch weather data using the service
        $weatherData = $this->weatherService->getWeatherData($city);

        if (!$weatherData) {
            // If no data exists in the database, fetch from the API and store it
            $this->weatherService->fetchAndStoreWeatherData($city);
            $weatherData = $this->weatherService->getWeatherData($city); //here I am fetching updated data
        }

        return view('welcome', compact('weatherData'));
    }


}
