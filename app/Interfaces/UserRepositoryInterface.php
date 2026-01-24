<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\DTOs\UserFilterDTO;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function create(array $data): User;

    public function getActiveUsers(UserFilterDTO $filters): LengthAwarePaginator;
}