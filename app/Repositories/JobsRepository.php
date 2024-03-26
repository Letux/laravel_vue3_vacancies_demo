<?php

namespace App\Repositories;

use App\Enums\SortOrder;
use App\Models\JobVacancy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

final readonly class JobsRepository
{
    public function getList(?Carbon $dateFrom, ?Carbon $dateTo, ?string $sortBy, ?SortOrder $sortOrder ): Collection
    {
        $query = JobVacancy::query();

        if ($dateFrom) {
            $query->where('created_at', '>=', $dateFrom->startOfDay());
        }

        if ($dateTo) {
            $query->where('created_at', '<=', $dateTo->endOfDay());
        }

        if ($sortBy) {
            $query->orderBy($sortBy, $sortOrder->value);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query
            ->with('user')
            ->get();
    }
}
