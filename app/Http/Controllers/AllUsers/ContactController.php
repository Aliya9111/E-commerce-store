<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function Contact(){
        return view('AllUsersPages/ContactUs/Contact');
    }
}
