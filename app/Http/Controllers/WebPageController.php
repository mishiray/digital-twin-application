<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebPageController extends Controller
{
    function login()
    {
        return view('welcome');
    }
    function register()
    {
        return view('register');
    }
}
