<?php

namespace App\Http\Controllers;
use App\Models\Winners;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LuckyWinnersController extends Controller
{
    public function index() {
        $winners = Winners::orderBy('date', 'desc')->simplePaginate(5);

        return view('gewinner', [
            'winners' => $winners,
        ]);
    }

    public function store()
    {
        $messages = [
            'winner_name.min' => 'There are no names to save.',
        ];

        request()->validate([
            'winner_name' => ['required', 'string', 'min:5'],
        ], $messages);

       Winners::create([
            'winner_name' => request('winner_name'),
            'date' => Carbon::now(),
        ]);

        return redirect('/gewinner');
    }
}
