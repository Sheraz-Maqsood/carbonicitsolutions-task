<?php
namespace App\Repositories;

interface WeatherRepositoryInterface
{
    public function getData();
    public function saveData($data);
    public function getWeatherDataByCity(string $city);
}

