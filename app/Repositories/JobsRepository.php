<?php

namespace App\Repositories;

use App\Models\JobVacancy;
use Illuminate\Database\Eloquent\Collection;

final readonly class JobsRepository
{
    public function getList(): Collection
    {
        return JobVacancy::orderBy('created_at', 'desc')
            ->with('user')
            ->get();
    }
}
