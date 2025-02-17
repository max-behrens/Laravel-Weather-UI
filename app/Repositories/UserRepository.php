<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Get all users.
     *
     * @return array
     */
    public function getAllUsers(): array
    {
        return User::all()->toArray();
    }

    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findUserById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    /**
     * Update an existing user.
     *
     * @param int $id
     * @param array $data
     * @return User
     */
    public function updateUser(int $id, array $data): User
    {
        $user = $this->findUserById($id);
        
        if ($user) {
            $user->update($data);
        }

        return $user;
    }

    /**
     * Delete a user by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        $user = $this->findUserById($id);

        if ($user) {
            return $user->delete();
        }

        return false;
    }
}
