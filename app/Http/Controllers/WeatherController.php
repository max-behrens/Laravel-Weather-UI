<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather($latitude, $longitude)
    {
        $apiKey = config('services.dark_sky.key'); // Ensure you store your API key in .env or config
        $url = "https://api.darksky.net/forecast/{$apiKey}/{$latitude},{$longitude}";

        // Call the Dark Sky API
        $response = Http::get($url);

        // Check if the request was successful
        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Unable to fetch weather data'], 500);
    }
}