<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vacancy\BookRequest;
use App\Http\Requests\Vacancy\StoreRequest;
use App\Http\Requests\Vacancy\UpdateRequest;
use App\Http\Resources\VacancyResource;
use App\Http\Resources\VacancyResourceCollection;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->authorize('viewAny', Vacancy::class);
        $vacancies = Vacancy::get();
        return VacancyResourceCollection::make($vacancies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Vacancy::class);
        $vacancy = Vacancy::create($request->validated());
        return response()->json($vacancy);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function show(Vacancy $vacancy)
    {
        $this->authorize('view', $vacancy);
        // return response()->json($vacancy);
        return VacancyResource::make($vacancy);
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
        $this->authorize('update', $vacancy);
        $vacancy->update($request->validated());
        return response()->json($vacancy);
    }

    public function book(BookRequest $request, Vacancy $vacancy)
    {
        $this->authorize('book', $vacancy);
        DB::transaction(function () use ($request) {
            $vacancy_id = $request->vacancy_id;
            $booked = Vacancy::select('workers_amount', 'workers_booked')->where('id', '=', "{$vacancy_id}")->get()->first();
            if ($booked->workers_amount <= $booked->workers_booked) {

                return response()->json(["message" => "this vacancy is inactive"]);
            }
            $workers_booked_inc = $booked->workers_booked + 1;
            if ($booked->workers_amount <= $workers_booked_inc) {
                Vacancy::where('id', '=', "{$vacancy_id}")->update(['status' =>  'inactive']);
            }
            Vacancy::where('id', '=', "{$vacancy_id}")->update(['workers_booked' =>  "{$workers_booked_inc}"]);
            $book = DB::table('user_vacancy')->insert($request->validated());
            return response()->json($book);
        });
    }

    public function unBook(BookRequest $request, Vacancy $vacancy)
    {
        $this->authorize('unBook', $vacancy);
        DB::transaction(function () use ($request) {
            $user_id = $request->user_id;
            $vacancy_id = $request->vacancy_id;
            $subscriptionCheck = DB::table('user_vacancy')
                ->where('user_id', '=', "{$user_id}")
                ->where('vacancy_id', '=', "{$vacancy_id}")
                ->get()
                ->count();
            if ($subscriptionCheck > 0) {
                $booked = Vacancy::select('workers_amount', 'workers_booked')->where('id', '=', "{$vacancy_id}")->get()->first();
                $workers_booked_dc = $booked->workers_booked - 1;
                Vacancy::where('id', '=', "{$vacancy_id}")->update(['workers_booked' =>  "{$workers_booked_dc}"], ['status' =>  'active']);
                DB::table('user_vacancy')->where('user_id', '=', "{$user_id}")->where('vacancy_id', '=', "{$vacancy_id}")->delete();
                return response()->json(["message" => "Unbooked"]);
            }
        });
        return response()->json(["message" => "User does not booked"]);
    }

    public function vacancy()
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacancy $vacancy)
    {
        $this->authorize('delete', $vacancy);
        $vacancy->delete();
        return response()->json(["message" => "Deleted"], 204);
    }
}
