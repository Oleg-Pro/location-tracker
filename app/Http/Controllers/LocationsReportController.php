<?php

namespace App\Http\Controllers;

use App\Services\PersonLocationsService;
use App\Services\UserPersonService;
use App\User;
use Illuminate\Http\Request;
//use App\Person;

class LocationsReportController extends Controller
{

    /**
     * @var PersonLocationsService
     */
    protected $personLocationsService;

    /**
     * @var UserPersonService
     */
    protected $userPersonService;

    /**
     * LocationsReportController constructor.
     * @param PersonLocationsService $personLocationsService
     */
    public function __construct(PersonLocationsService $personLocationsService, UserPersonService $userPersonService)
    {
        $this->middleware(['auth', 'verified']);
        $this->personLocationsService = $personLocationsService;
        $this->userPersonService = $userPersonService;
    }

    /**
     * @param User $user
     * @param $personId
     * @param null $date
     * @return mixed\
     */
    function personLocationsByDate(Request $request, $personId, $date=null)
    {
        $person = $this->personLocationsService->personLocationsByDate($request->user(), $personId, $date);

        return response()->json($person);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function personLocationsReport(Request $request)
    {
        $people = $this->userPersonService->getUserPeople($request->user(), 0);

        return view('locationsReport/person-locations-report', compact('people'));
    }

    public function peopleLastLocations(Request $request)
    {
        $peopleLocations = $this->personLocationsService->peopleLastLocations($request->user());

        return view('/locationsReport/people-locations', compact('peopleLocations'));
    }
}
