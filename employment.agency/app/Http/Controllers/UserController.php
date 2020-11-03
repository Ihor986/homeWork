<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\StatsUserResource;
use App\Http\Resources\UserResourceCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->authorizeResource(User::class);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return $request;
        $this->authorize('viewAny', User::class);
        $search = "%{$request->search}%";
        $users = User::when($search, function ($query, $search) {
            return $query->where('first_name', 'like', $search)
                ->orWhere('last_name', 'like', $search)
                ->orWhere('city', 'like', $search)
                ->orWhere('country', 'like', $search);
        })->get(); //;with('')->paginate()
        return UserResourceCollection::make($users);
    }

    // public function index()
    // {
    //     // return $request;
    //     $this->authorize('viewAny', User::class);
    //     $users = User::get(); //;with('')->paginate()
    //     return UserResourceCollection::make($users);
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        // return response()->json($user);
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user->update($request->validated());
        return response()->json($user);
    }

    public function statsUser()
    {
        $this->authorize('viewAny', User::class);
        $admin = User::select(DB::raw('COUNT(role) as admin'))->where('role', 'admin')->get()->first();
        $worker = User::select(DB::raw('COUNT(role) as worker'))->where('role', 'worker')->get()->first();
        $employer = User::select(DB::raw('COUNT(role) as employer'))->where('role', 'employer')->get()->first();
        $users = array_merge(json_decode($admin, true), json_decode($worker, true), json_decode($employer, true));
        return response()->json($users);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return response()->json(["message" => "Deleted"], 204);
    }
}
