<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Status;
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
    try {
        $data = Status::orderBy('datetimes')
            ->selectRaw('datetimes as x, temperature as y')
            ->get();

        return response()->json($data);
    } catch (\Exception $e) {
        Log::error('Temperature data fetch error: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to fetch data'], 500);
    }

    //return response()->json(['test' => true]);

    //return Status::orderBy('datetimes')
      //  ->selectRaw('datetimes as time, temperature as value')
       // ->get()
       // ->map(function ($row) {
           // return [strtotime($row->time) * 1000, (float) $row->value];
        //});
}
}
