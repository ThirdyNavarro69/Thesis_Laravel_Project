<?php

namespace App\Http\Controllers\StudioOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudioMemberController extends Controller
{
    public function index()
    {
        return view('owner.view-members');
    }

    public function invite()
    {
        return view('owner.invite-members');
    }

    public function apply()
    {
        return view('owner.apply-members');
    }

}
