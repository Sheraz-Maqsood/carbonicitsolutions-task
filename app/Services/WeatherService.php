<?php
namespace App\Services;

use App\Repositories\WeatherRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected $weatherRepository;

    public function __construct(WeatherRepositoryInterface $weatherRepository)
    {
        $this->weatherRepository = $weatherRepository;
    }

    public function fetchAndStoreWeatherData($city)
    {

        try {
            Log::info('Requesting weather data', [
                'url' => 'https://api.weatherapi.com/v1/current.json',
                'params' => [
                    'key' => config('services.weather.api_key'),
                    'q' => $city,
                ]
            ]);
            Log::info('Weather API Key', ['key' => env('WEATHER_API_KEY')]);

            $response = retry(3, function () use ($city) {
                return Http::get('https://api.weatherapi.com/v1/current.json', [
                    'key' => config('services.weather.api_key'),
                    'q' => $city,
                ]);
            }, 100);

            Log::info('Weather API response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
            $this->weatherRepository->saveData([
                    'city' => $city,
                    'location' => $response->json()['location']['name'],
                    'temperature' => $response->json()['current']['temp_c'],
                    'description' => $response->json()['current']['condition']['text'],
                ]);
            } else {
                Log::error('Failed to fetch weather data', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Weather API request failed', ['error' => $e->getMessage()]);
        }
    }



    public function getWeatherData(string $city)
    {
        // I retrieved data using the repository
        return $this->weatherRepository->getWeatherDataByCity($city);
    }
}
