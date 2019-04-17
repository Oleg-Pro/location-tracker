<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePerson;
use App\Person;
use App\City;
use App\Services\UserPersonService;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    protected $userPersonService;

    /**
     * PersonController constructor.
     * @param UserPersonService $userPersonService
     */
    public function __construct(UserPersonService $userPersonService)
    {
        $this->userPersonService = $userPersonService;
        $this->middleware(['auth', 'verified']);
        $this->authorizeResource(Person::class, 'person');
    }


    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $people = $this->userPersonService->getUserPeople($request->user());
        $paginated = true;

        return view('people.index', compact('people','paginated'));
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
     * @param StorePerson $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StorePerson $request)
    {
        $validatedData = $request->validated();
        $this->userPersonService->create($validatedData, $request->user());

        return redirect('/people')->with('status', 'Person has been added');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        $person->load('city', 'user');
        $cities = City::orderBy('name')->get();

        return view('people.edit', compact('cities', 'person'));
    }

    /**
     * @param StorePerson $request
     * @param Person $person
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StorePerson $request, Person $person)
    {
        $validatedData = $request->validated();
        $this->userPersonService->update($person, $validatedData);

        return redirect('/people')->with('status', 'Person has been updated');
    }

    /**
     * @param Person $person
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Person $person)
    {
        $this->userPersonService->delete($person);

        return redirect()->route('people.index')->with('success', 'Stock has been deleted Successfully');
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

}
