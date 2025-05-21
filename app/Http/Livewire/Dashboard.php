<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AcessRoom;

class Dashboard extends Component
{
    public function render()
{
    $data = AcessRoom::orderBy('date', 'desc')->get();
    return view('livewire.dashboard', ['data' => $data]);
}

}
