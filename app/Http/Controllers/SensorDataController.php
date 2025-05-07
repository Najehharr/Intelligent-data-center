<?php
namespace App\Http\Controllers;
use App\Models\Status;
use Illuminate\Http\JsonResponse;

class SensorDataController extends Controller
{
    public function temperature(): JsonResponse
    {
        $data = Status::orderBy('datetimes', 'asc')
            ->limit(50)
            ->get(['temperature', 'datetimes']);

        $formatted = $data->map(function ($item) {
            return [
                'x' => strtotime($item->datetimes) * 1000,
                'y' => $item->temperature
            ];
        });

        return response()->json($formatted);
    }




    public function humidity(): JsonResponse
{
    $data = Status::orderBy('datetimes', 'asc')
        ->limit(50)
        ->get(['humidete', 'datetimes']);

    $formatted = $data->map(function ($item) {
        return [
            'x' => strtotime($item->datetimes) * 1000,
            'y' => $item->humidete, // Use 'humidete' instead of 'humidity'
        ];
    });

    return response()->json($formatted);
}




    public function gas(): JsonResponse
{
    $data = Status::orderBy('datetimes', 'asc')
        ->limit(50)
        ->get(['niveauco2', 'datetimes']); // 'niveauco2' for gas data

    $formatted = $data->map(function ($item) {
        return [
            'x' => strtotime($item->datetimes) * 1000,
            'y' => $item->niveauco2, // Use 'niveauco2' instead of 'gas_a' or similar
        ];
    });

    return response()->json($formatted);
}

}
