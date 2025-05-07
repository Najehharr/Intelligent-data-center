<?php

namespace App\Http\Controllers;

use App\Models\GasSensor;
use Illuminate\Http\Request;

class GasSensorController extends Controller
{
    public function store(Request $request)
    {
        GasSensor::create([
            'value' => $request->value,
            'time' => now(),
        ]);
        return response()->json(['message' => 'Gas value stored']);
    }

    public function latest()
    {
        return GasSensor::latest('time')->first();
    }

    public function chartData()
{
    return Status::orderBy('datetimes')
        ->selectRaw('datetimes as time, niveauco2 as value')
        ->get()
        ->map(function ($row) {
            return [strtotime($row->time) * 1000, (float) $row->value];
        });
}
}
