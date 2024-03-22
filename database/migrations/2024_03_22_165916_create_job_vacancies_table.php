<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateJobVacanciesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('job_vacancies')) {
            Schema::create('job_vacancies', function (Blueprint $table) {
                $table->increments('id');

                $table->unsignedBigInteger('user_id');
                $table->string('title');
                $table->text('description');

                $table->softDeletes();

                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('job_vacancies');
    }
}
