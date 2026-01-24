<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Create a new user and trigger registration events.
     *
     * @param array<string, mixed> $data
     */
    public function registerUser(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user', // Default role
            'active' => true, // Default active
        ]);

        UserRegistered::dispatch($user);

        return $user;
    }
}