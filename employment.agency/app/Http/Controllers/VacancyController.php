<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vacancy\StoreRequest;
use App\Http\Requests\Vacancy\UpdateRequest;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorizeResource('viewAny', Vacancy::class);
        $vacancies = Vacancy::get();
        return response()->json($vacancies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->authorizeResource('create', Vacancy::class);
        $vacancy = Vacancy::create($request->validated());
        return response()->json($vacancy, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function show(Vacancy $vacancy)
    {
        $this->authorizeResource('view', $vacancy);
        return response()->json($vacancy);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Vacancy $vacancy)
    {
        $this->authorizeResource('update', $vacancy);
        $vacancy->update($request->validated()); //->validated()
        return response()->json($vacancy);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacancy $vacancy)
    {
        $this->authorizeResource('delete', $vacancy);
        $vacancy->delete();
        return response()->json(["message" => "Deleted"], 204);
    }
}
