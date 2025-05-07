<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RfidSensorController extends Controller
{
    public function index()
    {
        $data = AcessRoom::orderBy('date', 'desc')->get();
        return view('rfid-dashboard', compact('data'));
    }
}
