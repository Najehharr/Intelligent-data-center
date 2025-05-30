<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RfidController extends Controller
{
    public function search(Request $request)
    {
        $date = $request->input('date');

        $data = DB::table('acessroom')
            ->whereDate('date', $date)
            ->get();

        return view('livewire.search', compact('data')); // updated here!
    }
}
