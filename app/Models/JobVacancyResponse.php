<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobVacancyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_vacancy_id',
        'user_id',
    ];

//    public function jobVacancy()
//    {
//        return $this->belongsTo(JobVacancy::class);
//    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
