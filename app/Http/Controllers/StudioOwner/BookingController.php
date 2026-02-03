<?php

namespace App\Http\Controllers\StudioOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('owner.view-bookings');
    }

    public function history()
    {
        return view('owner.booking-history');
    }
}
