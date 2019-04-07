<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Hotels;


class HotelsController extends Controller
{
    public function show()
    {
        $hotels = Hotels::all();
        return view('welcome', ['hotels' => $hotels]);
    }

    public function logSearch(Request $request)
    {
        $data = json_decode($request->getContent());

        Log::info('Search: ' . $data->{'search'});

        return response($data->{'search'}, 200);
    }
}
