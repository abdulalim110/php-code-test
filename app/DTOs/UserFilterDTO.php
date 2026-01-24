<?php

declare(strict_types=1);

namespace App\DTOs;

class UserFilterDTO
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly string $sortBy = 'created_at',
        public readonly string $sortDirection = 'desc',
        public readonly int $perPage = 10,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            search: $request->query('search'),
            sortBy: $request->query('sortBy', 'created_at'),
            sortDirection: 'desc', 
            perPage: (int) $request->query('per_page', 10),
        );
    }
}