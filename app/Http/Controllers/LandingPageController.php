<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{

    public function index()
    {
        return view('new_welcome');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function home()
    {
        return view('home');
    }
}
