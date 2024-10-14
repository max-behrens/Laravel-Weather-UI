<?php

namespace App\Http\Controllers;

use App\Models\User; // Import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
     // Serve the main view for the user list
     public function index()
     {
         return view('users.index'); // Return the view for user list
     }
 
     public function getFormattedUsers()
    {
        $users = User::all();

        return response()->json($users); // Return the users directly as JSON
    }
 
    //  public function apiIndex()
    //  {
    //      $users = User::all();
    //      return response()->json($users); // Return users in JSON format
    //  }

    public function create()
    {
        return view('users.add');  // Render the view for creating a user
    }

    public function store(Request $request)
    {

        Log::info('Storing user data:', $request->all());

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
        $user->password = bcrypt($validatedData['password']);
        $user->save();

        Log::info('User created successfully:', ['user_id' => $user->id]);

        return redirect()->route('users.index')->with('success', 'User added successfully');
    }

    public function show($id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if user is found
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Return the view with the user data
        return view('users.show', ['user' => $user]);
    }

    public function edit($id)
    {
          // Find the user by ID
          $user = User::find($id);

          // Check if user is found
          if (!$user) {
              return response()->json(['message' => 'User not found'], 404);
          }
  
          // Return the view with the user data
          return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $user->delete(); // Delete the user
    
        return response()->json(['message' => 'User deleted successfully']);
    }
}