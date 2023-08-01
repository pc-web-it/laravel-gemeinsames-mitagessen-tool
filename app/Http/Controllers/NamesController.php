<?php

namespace App\Http\Controllers;
use App\Models\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NamesController extends Controller
{
    public static function list (){
        
   
    
        $names = Name::all();
              
        return view('Names', ['names' => $names,]);
    }
    public function create (){
        
        return view('Names');

    }
    public function store(){
        $attributes = request()->validate([
            'name' => ['required', 'max:255']
        ]
        );
        Name::create($attributes);
        return redirect('Namen');
    }
    public static function testing (){
        $namen = DB::select('select * from names');
        return view('Names', ['namen' => $namen]);
    }

}
/*DB::insert('insert into names (id, name) values (?, ?)', [$id, $name]);//wie dass immer in neue spalte*/