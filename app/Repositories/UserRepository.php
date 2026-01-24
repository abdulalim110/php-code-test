<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTOs\UserFilterDTO;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function getActiveUsers(UserFilterDTO $filters): LengthAwarePaginator
    {
        $query = User::query()
            ->active()
            ->withCount('orders');

        // Logic Search (Name OR Email)
        if ($filters->search) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters->search}%")
                  ->orWhere('email', 'like', "%{$filters->search}%");
            });
        }

        // Logic Sorting
        $query->orderBy($filters->sortBy, $filters->sortDirection);

        return $query->paginate($filters->perPage);
    }
}