<?php

namespace App\Http\Controllers;

use App\Bookings;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function store(Request $request)
    {
        $data = json_decode($request->getContent());

        $request->validate([
            'name' =>'required',
            'email' => 'required|email',
            'creditCard' =>'required|digits:16'
        ]);

        Bookings::create([
            'rooms_id' => $data->{'roomId'},
            'email' => $data->{'email'},
            'name' => $data->{'name'},
            'price' => $data->{'price'},
            'credit_card' => $data->{'creditCard'}
        ]);

        return response($data->{'price'}, 200);
    }
}
