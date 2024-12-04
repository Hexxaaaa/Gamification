<?php

namespace App\Http\Controllers;

class FAQController extends Controller
{
    public function index()
    {
        return view('user.FAQ.index');
    }
}