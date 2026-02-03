<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingDetailsController extends Controller
{
    public function index()
    {
        return view('client.booking-details');
    }

    public function book(){
        return view('client.booking-forms');
    }
}
