<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PloiciesController extends Controller
{
    public function Policies(){
        return view('AllUsersPages.policies.policies');
    }
}
