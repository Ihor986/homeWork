<?php

namespace App\Policies;

use App\Http\Requests\Vacancy\BookRequest;
use App\Models\Organization;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VacancyPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->role == 'admin') {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {

        return true;
    }

    public function stats(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vacancy  $vacancy
     * @return mixed
     */
    public function view(User $user, Vacancy $vacancy)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->role == 'employer') {
            $vacancyOrganizationId = request()->organization_id;
            $creatorId = DB::table('organizations')->where('id', $vacancyOrganizationId)->get()->first()->user_id;
            return $user->id == $creatorId;
        };
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vacancy  $vacancy
     * @return mixed
     */
    public function update(User $user, Vacancy $vacancy)
    {
        $vacancyId = $vacancy->id;
        $creatorId = DB::table('organizations')->where('id', $vacancyId)->get()->first()->user_id;
        $vacancyOrganizationId = request()->organization_id;
        $updatorID = DB::table('organizations')->where('id', $vacancyOrganizationId)->get()->first()->user_id;
        return $user->id == $updatorID && $creatorId == $updatorID;
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vacancy  $vacancy
     * @return mixed
     */
    public function delete(User $user, Vacancy $vacancy)
    {
        $vacancyOrganizationId = $vacancy->id;
        $creatorId = DB::table('organizations')->where('id', $vacancyOrganizationId)->get()->first()->user_id;
        return $user->id == $creatorId;
    }



    public function book(User $user)
    {
        $request = request();
        $requestUserId = $request->user_id;
        return $user->id == $requestUserId;
    }

    public function unBook(User $user, Vacancy $vacancy)
    {

        $request = request();
        $requestUserId = $request->user_id;
        $vacancyId = $request->vacancy_id;
        $organizationId = DB::table('vacancies')->select('organization_id')->where('id', '=', "{$vacancyId}")->get()->first()->organization_id;
        $creatorId = DB::table('organizations')->select('user_id')->where('id', '=', "{$organizationId}")->get()->first()->user_id;

        if ($user->id == $requestUserId || $user->id == $creatorId) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vacancy  $vacancy
     * @return mixed
     */
    // public function restore(User $user, Vacancy $vacancy)
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vacancy  $vacancy
     * @return mixed
     */
    // public function forceDelete(User $user, Vacancy $vacancy)
    // {
    //     //
    // }
}
