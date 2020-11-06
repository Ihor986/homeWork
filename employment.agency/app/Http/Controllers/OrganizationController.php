<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organization\StoreRequest;
use App\Http\Requests\Organization\UpdateRequest;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationResourceCollection;
use App\Models\Organization;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Organization::class);
        $organizations = Organization::with('creator')->get();
        return response()->json($organizations);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Organization::class);
        $organization = Organization::create($request->validated() + ['user_id' => auth()->id()]);
        return response()->json($organization, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        $this->authorize('view', $organization);
        $request = request();
        $vacanciesRequest = $request->vacancies;
        $workers = $request->workers;
        $organizationId = $organization->id;
        $organization->load(['creator']);
        if ($workers == 1) {
            $vacancies = json_decode(Vacancy::where('organization_id', $organizationId)->get(), true);
            $vacanciesID = [];
            $usersObjectId = [];
            $usersId = [];
            foreach ($vacancies as $vacancy) {
                array_push($vacanciesID, $vacancy['id']);
            }
            $vacancyUsers = DB::table('user_vacancy')->select('user_id')->whereIn('vacancy_id', $vacanciesID)->get();
            array_push($usersObjectId, json_decode($vacancyUsers, true));
            $usersArr = Arr::collapse($usersObjectId);
            foreach ($usersArr as $user) {
                array_push($usersId, $user['user_id']);
            }
            $users = User::whereIn('id', $usersId)->get();
            if ($vacanciesRequest == 1) {
                $vacancy = Vacancy::where('organization_id', $organizationId)->where('status', 'active')->get();
                return response()->json(array_merge(json_decode($organization, true), ['vacancies' => json_decode($vacancy, true)], ['workers' => json_decode($users, true)]));
            } else if ($vacanciesRequest == 2) {
                $vacancy = Vacancy::where('organization_id', $organizationId)->where('status', 'closed')->get();
                return response()->json(array_merge(json_decode($organization, true), ['vacancies' => json_decode($vacancy, true)], ['workers' => json_decode($users, true)]));
            } else if ($vacanciesRequest == 3) {
                $vacancy = Vacancy::where('organization_id', $organizationId)->get();
                return response()->json(array_merge(json_decode($organization, true), ['vacancies' => json_decode($vacancy, true)], ['workers' => json_decode($users, true)]));
            } else {
                return response()->json(array_merge(json_decode($organization, true), ['workers' => json_decode($users, true)]));
            }
        } else {
            if ($vacanciesRequest == 1) {
                $vacancy = Vacancy::where('organization_id', $organizationId)->where('status', 'active')->get();
                return response()->json(array_merge(json_decode($organization, true), ['vacancies' => json_decode($vacancy, true)]));
            } else if ($vacanciesRequest == 2) {
                $vacancy = Vacancy::where('organization_id', $organizationId)->where('status', 'closed')->get();
                return response()->json(array_merge(json_decode($organization, true), ['vacancies' => json_decode($vacancy, true)]));
            } else if ($vacanciesRequest == 3) {
                $vacancy = Vacancy::where('organization_id', $organizationId)->get();
                return response()->json(array_merge(json_decode($organization, true), ['vacancies' => json_decode($vacancy, true)]));
            } else {
                return response()->json($organization);
            }
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Organization $organization)
    {
        $this->authorize('update', $organization);
        $organization->update($request->validated());
        return response()->json($organization);
    }

    public function statsOrganization()
    {
        $this->authorize('stats', Organization::class);
        $active = Organization::select(DB::raw('COUNT(id) as `Active`'))->get()->first();
        $softDelete = Organization::withTrashed()->select(DB::raw('COUNT(deleted_at) as `SoftDelete`'))->get()->first();
        $all = Organization::withTrashed()->select(DB::raw('COUNT(id) as `ALL`'))->get()->first();
        $organization = array_merge(json_decode($active, true), json_decode($softDelete, true), json_decode($all, true));
        return response()->json($organization);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        $this->authorize('delete', $organization);
        $organization->delete();
        return response()->json(["message" => "Deleted"], 204);
    }
}
