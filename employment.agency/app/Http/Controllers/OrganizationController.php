<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organization\StoreRequest;
use App\Http\Requests\Organization\UpdateRequest;
use App\Http\Resources\OrganizationResourceCollection;
use App\Models\Organization;
use App\Models\User;
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
        $organizations = Organization::with(User::class)->get();
        return OrganizationResourceCollection::make($organizations);
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
        $organization->load(['users']);
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
        $this->authorize('viewAny', Organization::class);
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
