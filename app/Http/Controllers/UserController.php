<?php

namespace App\Http\Controllers;

use App\Models\User; // Example model import
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */

     public function index()
    {
        $users = User::all(); // Fetch all users from the database
        return view('users.index', compact('users')); // Pass the users variable to the view
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Create a new user
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']); // Hash the password
        $user->save();

        // Redirect to user index with success message
        return redirect()->route('users.index')->with('success', 'Record Inserted');
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate and update user data (e.g., using the User model)
        // Example: 
        // $validated = $request->validate([
        //     'name' => 'required|max:255',
        //     'email' => 'required|email|unique:users,email,' . $id,
        // ]);
        // $user = User::findOrFail($id);
        // $user->update($validated);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        // Example: User::destroy($id);

        return redirect()->route('users.index');
    }


}