<?php

namespace App\Http\Controllers;
use App\Models\Winners;


use Illuminate\Http\Request;

class LuckyWinnersController extends Controller
{
    public function index() {
        $winners = Winners::all(); 

        return view('gewinner', compact('winners')); 
    }
}
