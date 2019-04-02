<?php

namespace App\Http\Controllers;

use App\Person;
use App\City;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $people = Person::with(['city', 'user'])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->whereHas('user', function($query) use ($user) {
                $query->where('id', $user->id);
            })->get();

        return view('people.index', compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::orderBy('name')->get();

        return view('people.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->storePerson($request);

        return redirect('/people')->with('status', $result);
    }

    /**
     * @param Request $request
     * @param $personId
     * @param $date
     * @return \Illuminate\Http\Response
     */
    function personLocations(Request $request, $personId, $date=null)
    {
        if (!isset($date)) {
            $date = date('Y-m-d');
        }
        $user = $request->user();

        $person = Person::where('id', '=', $personId)
            ->with(['city', 'personLocations' => function($query) use ($date) {
                $query->whereRaw('date(created_at) = ?', [$date])
                ->orderBy('created_at');
            }])
            ->whereHas('user', function($query) use ($user) {
                $query->where('id', $user->id);
            })->get();

        return $person->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Person $person)
    {
        $user = $request->user();
        $person->load('city', 'personLocations')
            ->whereHas('user', function($query) use ($user) {
                $query->where('id', $user->id);
            });

        return $person->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        $person->load('city');
        $cities = City::orderBy('name')->get();

        return view('people.edit', compact('cities', 'person'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        $result = $this->storePerson($request, $person);

        return redirect('/people')->with('status', $result);
    }

    /**
     * @param Request $request
     * @param Person|null $person
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function storePerson(Request $request, Person $person=null)
    {
        $validatedData = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'first_name' => 'required|max:50',
            'second_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'nullable|email|max:255',
            'phone' => 'max:20',
        ]);

        if ($person) {
            $editing = true;
        } else {
            $editing = false;
            $person = new Person();
        }
        $person->fill($validatedData);
        $person->user()->associate($request->user());
        $person->save();

        $result = ($editing) ? 'Stock has been updated' : 'Stock has been added';

        return $result;
    }


    /**
     * @param integer $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        Person::destroy($id);

        return redirect()->route('people.index')->with('success', 'Stock has been deleted Successfully');
    }
}
