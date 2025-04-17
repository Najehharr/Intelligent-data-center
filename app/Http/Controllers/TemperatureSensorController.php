<?php

namespace App\Http\Controllers;

use App\Models\TemperatureSensor;
use Illuminate\Http\Request;

class TemperatureSensorController extends Controller
{
    public function store(Request $request)
    {
        TemperatureSensor::create([
            'value' => $request->value,
            'time' => now(),
        ]);
        return response()->json(['message' => 'Stored']);
    }

    public function latest()
    {
        return TemperatureSensor::latest('time')->first();
    }

    public function chartData()
    {
        return TemperatureSensor::orderBy('time')->get(['time', 'value']);
    }
}
