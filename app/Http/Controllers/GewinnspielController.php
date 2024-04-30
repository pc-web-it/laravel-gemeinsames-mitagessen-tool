<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GewinnspielController extends Controller
{
    public function index() {
        return view('gewinnspiel');
    }
}
