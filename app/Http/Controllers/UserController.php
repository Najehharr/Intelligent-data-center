<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Added for password hashing if needed, though not in your current update logic

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
{
    $users = User::all();
return view('livewire.example-laravel.user-management', compact('users'));
}



    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('create-user'); // Assuming you have a create-user.blade.php
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8', // Add password validation
            'role' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'role' => $request->role,
        ]);

        return redirect()->route('user-management')->with('message', 'Utilisateur créé avec succès.');
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user) // Use Route Model Binding
    {
        // The view name should be 'edit-user' or integrated into 'user-management'
        // Based on your blade, 'user-management' handles both listing and an edit form.
        return view('user-management', ['users' => User::all(), 'editUser' => $user]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user) // Use Route Model Binding
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // Exclude current user's email
            'role' => 'required|string',
            // 'password' => 'nullable|string|min:8|confirmed', // Add if you allow password change
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // If you allow password changes in the edit form:
        // if ($request->filled('password')) {
        //     $user->password = Hash::make($request->password);
        // }

        $user->save();

        // Redirect to the user management list after update
        return redirect()->route('user-management')->with('message', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user) // Use Route Model Binding
    {
        $user->delete();
        // Redirect to the user management list after deletion
        return redirect()->route('user-management')->with('message', 'Utilisateur supprimé.');
    }

    /**
     * Display the dashboard for a normal user.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('user.dashboard'); // Assuming a view like resources/views/user/dashboard.blade.php
    }
}
