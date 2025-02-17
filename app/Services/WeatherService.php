<?php

// app/Services/WeatherService.php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeatherData($latitude, $longitude)
    {
        $apiKey = config('services.dark_sky.key');
        $url = "https://api.darksky.net/forecast/{$apiKey}/{$latitude},{$longitude}";

        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
