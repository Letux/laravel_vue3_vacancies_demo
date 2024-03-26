<?php

namespace App\Repositories;

use App\Models\User;

final readonly class UserRepository
{
    public function decrementCoins(int $userId, int $amount): void
    {
        User
            ::where('id', $userId)
            ->decrement('coins', $amount);
    }
}
