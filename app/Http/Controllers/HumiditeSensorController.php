<?php

namespace App\Http\Controllers;

use App\Models\HumiditeSensor;
use Illuminate\Http\Request;

class HumiditeSensorController extends Controller
{
    public function store(Request $request)
    {
        HumiditeSensor::create([
            'value' => $request->value,
            'time' => now(),
        ]);
        return response()->json(['message' => 'Humidity value stored']);
    }

    public function latest()
    {
        return HumiditeSensor::latest('time')->first();
    }

    public function chartData()
{
    return Status::orderBy('datetimes')
        ->selectRaw('datetimes as time, humidete as value')
        ->get()
        ->map(function ($row) {
            return [strtotime($row->time) * 1000, (float) $row->value];
        });
}
}
