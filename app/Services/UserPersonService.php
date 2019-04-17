<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 09.04.19
 * Time: 14:59
 */

namespace App\Services;


use App\Person;
use App\User;

class UserPersonService
{

    /**
     * @param array $data
     * @param User $user
     * @return Person
     */
    public function create(array $data, User $user)
    {
        $person = new Person();
        $person->fill($data);
        $person->user()->associate($user);
        $person->save();

        return $person;
    }

    /**
     * @param Person $person
     * @param array $data
     * @return Person
     */
    public function update(Person $person, array $data)
    {
        $person->fill($data);
        $person->save();

        return $person;
    }


    /**
     * @param Person $person
     * @throws \Exception
     */
    public function delete(Person $person)
    {
        $person->delete();
    }

    /**
     * @param int $id
     * @param User $user
     * @return Person|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
//    public function getUserPerson(int $id, User $user)
//    {
//        $person = Person::with('city', 'user')->where('id', '=', $id)
//            ->whereHas('user', function($query) use ($user) {
//                $query->where('id', $user->id);
//            })->first();
//
//        return $person;
//    }

    /**
     * Get tracked people of the user
     * @param User $user
     * @param int $perPage
     * @return Person[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUserPeople(User $user, int $perPage = 10)
    {
        $query =  Person::with(['city', 'user'])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->whereHas('user', function($query) use ($user) {
                $query->where('id', $user->id);
            });

        return ($perPage > 0) ? $query->paginate($perPage) : $query->get();
    }
}