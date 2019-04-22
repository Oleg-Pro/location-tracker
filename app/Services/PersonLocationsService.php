<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 19.04.19
 * Time: 10:50
 */

namespace App\Services;

use App\User;
use App\Person;
use Illuminate\Support\Facades\DB;

class PersonLocationsService
{
    /**
     * @param User $user
     * @param $personId
     * @param null $date
     * @return mixed
     */
    function personLocationsByDate(User $user, $personId, $date=null)
    {
        if (!isset($date)) {
            $date = date('Y-m-d');
        }

        $person = Person::where('id', '=', $personId)
            ->with(['city', 'user', 'personLocations' => function($query) use ($date) {
                $query->whereRaw('date(created_at) = ?', [$date])
                    ->orderBy('created_at');
            }])
            ->whereHas('user', function($query) use ($user) {
                $query->where('id', $user->id);
            })->first();

        return $person;
    }

    function peopleLastLocations(User $user)
    {
        $peopleLocations = DB::table('person_locations')
            ->join('people', 'people.id', '=', 'person_locations.person_id')
            ->join('users', 'users.id', '=', 'people.user_id')
            ->select(
                'person_locations.*', 'people.first_name', 'people.second_name', 'people.last_name',
                'people.email', 'people.phone'
            )
            ->join(DB::raw('(SELECT person_id, MAX(created_at) AS created_at
                             FROM person_locations
                             GROUP BY person_id) last_coordinates'), function ($join) {
                $join->on('last_coordinates.person_id', '=', 'person_locations.person_id')
                    ->on('last_coordinates.created_at', '=', 'person_locations.created_at');
            })->where('users.id', '=', $user->id)->get();

        return $peopleLocations;
    }
}