<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HumiditeSensorController extends Controller
{
    public function latest()
    {
        $humidity = Humidity::latest()->first();
        return response()->json($humidity);
    }

}
