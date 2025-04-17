<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GasSensor;

class GasSensorController extends Controller
{
    /// ✅ Store gas level
    public function storeGasLevel(Request $request) {
        $request->validate([
            'value' => 'required|numeric',
        ]);

        $gasSensor = GasSensor::create([
            'value' => $request->value,
        ]);

        // Check if value exceeds threshold
        if ($this->checkThreshold($request->value)) {
            $this->sendAlert($request->value);
        }

        return response()->json($gasSensor, 201);
    }

    // ✅ Retrieve the latest gas level
    public function latest()
{
    $gas = GasSensor::latest()->first(); // or Co2Level model
    return response()->json($gas);
}

    // ✅ Check if gas level exceeds threshold
    private function checkThreshold($value) {
        $threshold = 100; // Change based on your needs
        return $value > $threshold;
    }

    // ✅ Send alert if threshold exceeded
    private function sendAlert($value) {
        Log::warning("⚠️ Alert: High gas level detected ($value)!");
        // You can add email/SMS/notification logic here
    }

}
