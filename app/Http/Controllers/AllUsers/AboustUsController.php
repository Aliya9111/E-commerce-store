<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboustUsController extends Controller
{
    public function AboutUs(){
        return view('AllUsersPages.AboutUs');
    }
}
