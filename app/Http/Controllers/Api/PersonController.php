<?php

namespace App\Http\Controllers\Api;

use App\Services\UserPersonService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePerson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Person;
use App\Http\Resources\Person as PersonResource;

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
        $this->middleware('auth:api');
        $this->authorizeResource(Person::class, 'person');
    }


    /**
     * Display user people
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $people = $this->userPersonService->getUserPeople($request->user());
        return PersonResource::collection($people);
    }

    /**
     * @param StorePerson $request
     * @return PersonResource
     */
    public function store(StorePerson $request)
    {
        $validatedData = $request->validated();
        $person = $this->userPersonService->create($validatedData, $request->user());

        return new PersonResource($person);
    }

    /**
     * @param Person $person
     * @return PersonResource
     */
    public function show(Person $person)
    {
        return new PersonResource($person);
    }

    /**
     * @param StorePerson $request
     * @param Person $person
     * @return PersonResource
     */
    public function update(StorePerson $request, Person $person)
    {
        $validatedData = $request->validated();
        $this->userPersonService->update($person, $validatedData);

        return new PersonResource($person);
    }

    /**
    /**
     * Remove person
     *
     * @param Person $person
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Person $person)
    {
        $this->userPersonService->delete($person);

        return response()->json(null, 204);
    }
}
