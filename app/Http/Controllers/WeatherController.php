<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        return view('weather');
    }

    public function search(Request $request)
    {
        $city = $request->input('city');
        $apiKey = env('OPENWEATHER_API_KEY');

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $city . ',BR',
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'pt_br'
        ]);

        if ($response->successful()) {
            $weatherData = $response->json();
            $currentTime = time();
            $isDay = $currentTime > $weatherData['sys']['sunrise'] && $currentTime < $weatherData['sys']['sunset'];
            
            return view('weather', [
                'weatherData' => $weatherData, 
                'city' => $city,
                'isDay' => $isDay
            ]);
        } else {
            return view('weather', ['error' => 'Cidade não encontrada.']);
        }
    }
}