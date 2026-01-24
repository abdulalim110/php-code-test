<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $currentUser = $request->user();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role, 
            'created_at' => $this->created_at->toIso8601String(),
            'orders_count' => $this->whenCounted('orders'),
            'can_edit' => $this->calculateCanEdit($currentUser),
        ];
    }

    /**
     * Calculate permissions based on requirements.
     * * Rules:
     * - Admin: Can edit any user.
     * - Manager: Can only edit 'user' role.
     * - User: Can only edit themselves.
     */
    private function calculateCanEdit($currentUser): bool
    {
        if (! $currentUser) {
            return false;
        }

        if ($currentUser->id === $this->id) {
            return true;
        }

        return match ($currentUser->role) {
            RoleEnum::ADMIN => true,
            RoleEnum::MANAGER => $this->role === RoleEnum::USER,
            default => false,
        };
    }
}