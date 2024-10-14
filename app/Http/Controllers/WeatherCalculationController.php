<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeatherCalculationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'city_name' => 'required|string',
            'temperature' => 'required|numeric',
            'weather_description' => 'required|string',
        ]);

        SavedWeatherCalculation::create($request->all());

        return redirect()->back()->with('success', 'Weather data saved successfully!');
    }
}
