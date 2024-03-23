<?php

namespace App\Http\Resources;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin JobVacancy */
final class JobVacancyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'response_count' => $this->response_count,
            'published' => $this->created_at->format('d/m/Y H:i'),
            'user' => new UserResource($this->user),
        ];
    }
}
