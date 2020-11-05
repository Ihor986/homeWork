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
        // return $this->success(OrganizationResource::make($organizations));
        // return OrganizationResourceCollection::make($organizations);
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
        // $request = request();
        // $vacancies = $request->vacancies;
        // $workers = $request->workers;
        $organizationId = $organization->id;
        // if ($workers == 0) {
        // } else if ($workers == 1) {
        // }
        $vacancy = Vacancy::where('organization_id', "{$organizationId}")->where('status', 'active')->get();
        $vacancy = Vacancy::where('organization_id', "{$organizationId}")->where('status', 'closed')->get();
        $vacancy = Vacancy::where('organization_id', "{$organizationId}")->get();
        return $vacancy;

        // when($workers == 1, function ($query, $request, $organizationId) {
        //     if ($vacancies == 1) {
        //         return $query->where(['organization_id', '=', "{$organizationId}"], ['status', '=', 'active']);
        //     } else if ($vacancies == 2) {
        //     } else if ($vacancies == 3) {
        //     } else {
        //     }
        // }, function ($query, $search) {
        // })->get();

        // $users = User::when($search, function ($query, $search) {
        //     return $query->where('first_name', 'like', $search)
        //         ->orWhere('last_name', 'like', $search)
        //         ->orWhere('city', 'like', $search)
        //         ->orWhere('country', 'like', $search);
        // })->get(); //;with('')->paginate()


        $organization->load(['creator']);
        // return $this->success(OrganizationResource::make($organization));
        // return OrganizationResourceCollection::make($organization);
        return response()->json($organization);
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
