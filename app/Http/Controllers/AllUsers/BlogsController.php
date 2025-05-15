<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function Blogs(){
        return view('AllUsersPages.Blogs.blogs');
    }
}
