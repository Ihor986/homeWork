<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vacancy\BookRequest;
use App\Http\Requests\Vacancy\StoreRequest;
use App\Http\Requests\Vacancy\UpdateRequest;
use App\Http\Resources\VacancyResource;
use App\Http\Resources\VacancyResourceCollection;
use App\Models\Organization;
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
    public function index(Request $request)
    {

        $this->authorize('viewAny', Vacancy::class);
        if ($request->only_active == 'false') {
            $vacancies = Vacancy::get();
        } else $vacancies = Vacancy::where('status', '=', 'active')->get();
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
        $user_id = $request->user_id;
        $vacancy_id = $request->vacancy_id;
        $subscriptionCheck = DB::table('user_vacancy')
            ->where('user_id', '=', "{$user_id}")
            ->where('vacancy_id', '=', "{$vacancy_id}")
            ->get()
            ->count();
        if ($subscriptionCheck == 0) {
            DB::transaction(function () use ($vacancy_id, $request) {
                $booked = Vacancy::select('workers_amount', 'workers_booked')->where('id', '=', "{$vacancy_id}")->get()->first();
                if ($booked->workers_amount <= $booked->workers_booked) {

                    return response()->json(["message" => "this vacancy is closed"]);
                }
                $workers_booked_inc = $booked->workers_booked + 1;
                if ($booked->workers_amount <= $workers_booked_inc) {
                    Vacancy::where('id', '=', "{$vacancy_id}")->update(['status' =>  'closed']);
                }
                Vacancy::where('id', '=', "{$vacancy_id}")->update(['workers_booked' =>  "{$workers_booked_inc}"]);
                $book = DB::table('user_vacancy')->insert($request->validated());
                return response()->json($book);
            });
        }
    }

    public function unBook(BookRequest $request, Vacancy $vacancy)
    {
        $this->authorize('unBook', $vacancy);
        $user_id = $request->user_id;
        $vacancy_id = $request->vacancy_id;
        $subscriptionCheck = DB::table('user_vacancy')
            ->where('user_id', '=', "{$user_id}")
            ->where('vacancy_id', '=', "{$vacancy_id}")
            ->get()
            ->count();
        if ($subscriptionCheck > 0) {
            DB::transaction(function () use ($user_id, $vacancy_id) {
                $booked = Vacancy::select('workers_amount', 'workers_booked')->where('id', '=', "{$vacancy_id}")->get()->first();
                $workers_booked_dc = $booked->workers_booked - 1;
                Vacancy::where('id', '=', "{$vacancy_id}")->update(['workers_booked' =>  "{$workers_booked_dc}"], ['status' =>  'active']);
                DB::table('user_vacancy')->where('user_id', '=', "{$user_id}")->where('vacancy_id', '=', "{$vacancy_id}")->delete();
            });
        } else return response()->json(["message" => "User does not booked"]);
        return response()->json(["message" => "Unbooked"]);
    }

    public function statsVacancy()
    {
        $this->authorize('stats', Vacancy::class);
        $active = Vacancy::select(DB::raw('COUNT(status) as active'))->where('status', 'active')->get()->first();
        $closed = Vacancy::select(DB::raw('COUNT(status) as closed'))->where('status', 'closed')->get()->first();
        $all = Vacancy::select(DB::raw('COUNT(status) as `all`'))->get()->first();
        $vacancies = array_merge(json_decode($active, true), json_decode($closed, true), json_decode($all, true));
        return response()->json($vacancies);
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
