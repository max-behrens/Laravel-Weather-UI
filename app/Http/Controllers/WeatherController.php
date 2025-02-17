<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getWeather($latitude, $longitude): array
    {
        $weatherData = $this->weatherService->getWeatherData($latitude, $longitude);
        return $weatherData ? response()->json($weatherData) : response()->json(['error' => 'Unable to fetch weather data'], 500);
    }
}