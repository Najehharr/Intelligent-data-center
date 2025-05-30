<?php


namespace App\Http\Controllers;

use App\Models\GasSensor;
use Illuminate\Http\Request;
class Co2StatusSensorController extends Controller
{
    public function store(Request $request)
    {
        GasSensor::create([
            'value' => $request->value,
            'time' => now(),
        ]);

        return response()->json(['message' => 'Stored']);
    }

    public function latest()
    {
        return GasSensor::latest('time')->first();
    }

    public function chartData()
    {
        $data = GasSensor::orderBy('time')->get(['time', 'value']);

        $formatted = [];

        foreach ($data as $row) {
            $timestamp = strtotime($row->time) * 1000;
            $formatted[] = [$timestamp, (float) $row->value];
        }

        return response()->json($formatted);
    }
}

