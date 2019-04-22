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

    public function apiKey(Request $request)
    {
        $apiKey = $request->user()->api_token;
        return view('api-key', compact('apiKey'));
    }

    public function generateApiKey(Request $request)
    {
        $apiKey = $request->user()->generateToken();
        return compact('apiKey');
    }
}
