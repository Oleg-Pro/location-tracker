<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StorePersonLocation;
use App\Services\PersonLocationsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PersonLocation as PersonLocationResource;

class PersonLocationController extends Controller
{
    /**
     * @var PersonLocationsService
     */
    protected $personLocationsService;

    /**
     * PersonLocationController constructor.
     * @param PersonLocationsService $personLocationsService
     */
    public function __construct(PersonLocationsService $personLocationsService)
    {
        $this->middleware('auth:api');
        $this->personLocationsService = $personLocationsService;
    }


    function personLocationsByDate(Request $request, $personId, $date=null)
    {
        $person = $this->personLocationsService->personLocationsByDate($request->user(), $personId, $date);

        return response()->json($person);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user('api');
        //return Article::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonLocation $request)
    {
        $validatedData = $request->validated();
        $personLocation = $this->personLocationsService->create($validatedData, $request->user());

//        return response()->json($personLocation);

        return new PersonLocationResource($personLocation);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
