<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userService;

    // Inject the UserService via constructor
    public function __construct(UserService $userService)
    {
        $this->userService = $userService; // Inject the UserService
    }

    /**
     * Show the user list view.
     */
    public function index()
    {
        return view('users.index'); // Return the user list view
    }

    /**
     * Get all users in a formatted way (e.g., JSON).
     */
    public function getFormattedUsers()
    {
        $users = $this->userService->getAllUsers();
        return response()->json($users); // Return users in JSON format
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.add');  // Render the view for creating a new user
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(CreateUserRequest $request)
    {
        Log::info('Storing user data:', $request->all());

        // Delegate user creation to the UserService
        $user = $this->userService->createUser($request->validated());

        Log::info('User created successfully:', ['user_id' => $user->id]);

        return redirect()->route('users.index')->with('success', 'User added successfully');
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = $this->userService->getUserById($id);

        // If the user is not found, return a 404 error
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Return the view with user data
        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = $this->userService->getUserById($id);

        // If the user is not found, return a 404 error
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Return the view with user data
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        Log::info('Update Request:', [
            'id' => $id,
            'route_id' => $request->segment(3),
            'email' => $request->input('email'),
            'validated_data' => $request->validated()
        ]);
        
        $data = $request->validated();
        $currentPassword = $request->input('password');

        $updatedUser = $this->userService->updateUser($id, $data, $currentPassword);

        if (!$updatedUser) {
            return response()->json(['message' => 'Failed to update user. Incorrect password or user not found.'], 400);
        }

        return response()->json(['message' => 'User updated successfully', 'user' => $updatedUser], 200);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $deleted = $this->userService->deleteUser($id);

        if (!$deleted) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['message' => 'User deleted successfully']);
    }
}
