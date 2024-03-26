<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

final class CreateJobDTO extends Data
{
    public function __construct(
        public string $title,
        public string $description,
    ) {}
}
