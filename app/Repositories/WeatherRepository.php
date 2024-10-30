<?php
namespace App\Repositories;

use App\Models\Weather;

class WeatherRepository implements WeatherRepositoryInterface
{
    public function getData() {
        return Weather::all();
    }

    public function saveData($data) {
        return Weather::create($data);
    }
    public function getWeatherDataByCity(string $city)
    {
        return Weather::where('city', $city)->first();
    }
}
