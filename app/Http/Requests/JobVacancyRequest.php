<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class JobVacancyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer'],
            'title' => ['required'],
            'description' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
