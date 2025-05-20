<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email;
    public $password;

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function mount()
    {
        // Optional: Prefill fields during development
        // $this->fill(['email' => 'admin@material.com', 'password' => 'secret']);
    }

    public function store()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $role = strtolower($user->role); // Normalize role to lowercase

            // Redirect based on normalized role
            if ($role === 'agent') {
                return redirect()->route('agent');
            } elseif ($role === 'technicien') {
                return redirect()->route('technicien');
            } else {
                Auth::logout();
                session()->flash('status', 'Rôle non reconnu.');
                return;
            }
        } else {
            session()->flash('status', 'Email ou mot de passe incorrect.');
        }
    }
}
