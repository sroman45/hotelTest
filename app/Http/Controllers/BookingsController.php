<?php

namespace App\Http\Controllers;

use App\Bookings;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function store(Request $request)
    {
        $data = json_decode($request->getContent());

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
