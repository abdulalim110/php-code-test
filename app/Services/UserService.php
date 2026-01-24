<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\UserFilterDTO;
use App\Events\UserRegistered;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    /**
     * Create a new user and trigger registration events.
     *
     * @param array<string, mixed> $data
     */
    public function registerUser(array $data): User
    {
        // Hash password di sini sebelum lempar ke repo
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'user';
        $data['active'] = true;

        // Panggil Repo
        $user = $this->userRepository->create($data);


        UserRegistered::dispatch($user);

        return $user;
    }

    public function getPaginatedUsers(UserFilterDTO $filters): LengthAwarePaginator
    {
        return $this->userRepository->getActiveUsers($filters);
    }
}