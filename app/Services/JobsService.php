<?php

namespace App\Services;

use App\DTOs\CreateJobDTO;
use App\DTOs\JobsListDTO;
use App\Events\JobCreatedEvent;
use App\Http\Resources\JobVacancyResource;
use App\Models\JobVacancy;
use App\Repositories\JobsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final readonly class JobsService
{
    public function __construct(private JobsRepository $repository)
    {
    }

    public function list(JobsListDTO $data): AnonymousResourceCollection
    {
        if ($data->sort_by === 'published') {
            $data->sort_by = 'created_at';
        }

        return JobVacancyResource::collection($this->repository->getList($data->date_from, $data->date_to, $data->sort_by, $data->sort_order));
    }

    public function create(CreateJobDTO $dto, int $userId): RedirectResponse
    {
        $job = $this->repository->create($dto->title, $dto->description, $userId);

        event(new JobCreatedEvent($job));

        return redirect()->route('jobs');
    }

    public function apply(JobVacancy $job, int $userId): JsonResponse
    {
        if ($job->user_id === $userId) {
            return response()->json(['message' => 'You cannot apply for your own job!'], 403);
        }

        if ($this->userAlreadyApplied($job, $userId)) {
            return response()->json(['message' => 'You have already applied for this job!'], 403);
        }

        if (!$this->repository->apply($job, $userId)) {
            return response()->json(['message' => 'An error occurred while applying for this job!'], 500);
        }

        return response()->json(['message' => 'You have successfully applied for this job!']);
    }

    private function userAlreadyApplied(JobVacancy $job, int $userId): bool
    {
        return $job->responses->contains($userId);
    }
}
