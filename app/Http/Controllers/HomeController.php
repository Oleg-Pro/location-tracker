<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Person;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     * @param Request request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = $request->user();
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

        return view('home', compact('peopleLocations'));
    }

    public function locationsReport(Request $request)
    {

        $user = $request->user();
        $people = Person::with(['city', 'user'])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->whereHas('user', function($query) use ($user) {
                $query->where('id', $user->id);
            })->get();

        return view('locations-report', compact('people'));
    }
}
