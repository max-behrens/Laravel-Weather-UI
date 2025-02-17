<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        // Validate user data
        $this->validateUserData($data, null);

        // Hash the password before saving the user
        $data['password'] = Hash::make($data['password']);

        return $this->repository->createUser($data);
        }

        /**
         * Update the user by ID.
         *
         * @param int $id
         * @param array $data
         * @param string|null $currentPassword
         * @return User|false
         */
        public function updateUser(int $id, array $data, string $currentPassword)
    {
        // Fetch the user to update
        $user = $this->repository->findUserById($id);

        if (!$user) {
            return false; // User not found
        }

        Log::info([
            'SERVICE $user->password' => $user->password
        ]);
        
        Log::info([
            'SERVICE $currentPassword' => $currentPassword
        ]);

        Log::info([
            'SERVICE HASH $currentPassword' => Hash::make($currentPassword)
        ]);
        // Check if the entered password matches the stored hash
        if (!Hash::check($currentPassword, $user->password)) {
            Log::warning("Password mismatch for user ID: {$user->id}");
            return false; // Incorrect password
        }

        // Remove password from data since it's only used for verification
        unset($data['password']);

        // Validate user data (e.g., name, email)
        $this->validateUserData($data, $id);

        // Update the user
        $user->update($data);

        return $user; // Return the updated user
    }

    
    /**
     * Delete the user by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        $user = $this->repository->findUserById($id);

        if (!$user) {
            return false; // User not found
        }

        return $user->delete(); // Delete the user
    }

    /**
     * Get a user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        return $this->repository->findUserById($id);
    }

    /**
     * Get all users.
     *
     * @return array
     */
    public function getAllUsers(): array
    {
        return $this->repository->getAllUsers();
    }

    /**
     * Validate user data.
     *
     * @param array $data
     * @throws ValidationException
     */
    private function validateUserData(array $data, ?int $userId)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255'
        ];

        // Add unique rule with exception for current user if updating
        if ($userId) {
            $rules['email'] .= '|unique:users,email,' . $userId;
        } else {
            $rules['email'] .= '|unique:users,email';
            // Only require password for new users
            $rules['password'] = 'required|string|min:8';
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
