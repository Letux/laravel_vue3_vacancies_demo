<?php

namespace App\DTOs;

use App\Enums\SortOrder;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\RequiredWith;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

final class JobsListDTO extends Data
{
    public function __construct(
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        public ?Carbon $date_from,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        public ?Carbon $date_to,

        #[In('published', 'response_count')]
        public ?string $sort_by,

        #[RequiredWith('sort_by')]
        public ?SortOrder $sort_order,
    ) {
    }
}
