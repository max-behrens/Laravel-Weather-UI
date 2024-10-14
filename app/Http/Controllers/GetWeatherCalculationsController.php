<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetWeatherCalculationsController extends Controller
{
    public function index()
    {
        $calculations = SavedWeatherCalculation::all();
        return view('saved_calculations', compact('calculations'));
    }
}
