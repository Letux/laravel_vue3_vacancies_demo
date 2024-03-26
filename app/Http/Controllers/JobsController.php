<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class JobsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Jobs/Index', ['fetchJobsUrl' => route('api.jobs.list')]);
    }

//    public function create()
//    {
//    }
//
//    public function store(Request $request)
//    {
//    }
//
//    public function show($id)
//    {
//    }
//
//    public function edit($id)
//    {
//    }
//
//    public function update(Request $request, $id)
//    {
//    }
//
//    public function destroy($id)
//    {
//    }
}
