<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateJobVacancyResponsesTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('job_vacancy_responses')) {
            Schema::create('job_vacancy_responses', function (Blueprint $table) {
                $table->increments('id');

                $table->unsignedInteger('job_vacancy_id');
                $table->foreign('job_vacancy_id')->references('id')->on('job_vacancies')->onDelete('cascade');

                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('job_vacancy_responses');
    }
}
