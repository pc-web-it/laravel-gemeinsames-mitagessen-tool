<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Name;
use App\Models\Date;  
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

    public function updateName($id) 
    {
        $attributes = request()->validate([
            'name' => ['required', 'max:255']
        ]);
    
        // Daten in Tabelle „employees“ aktualisieren
        $name = Name::findOrFail($id);
        $name->update($attributes);
    
        // Rufen Sie einen Datensatz anhand der ID aus der Datumstabelle ab und aktualisieren Sie seinen Namen
        $date = Date::where('namepraesentiertid', $id)->first();
    
        if ($date && $date->namepraesentiertid == $id) {
            $date->update(['namepraesentiert' => $attributes['name']]);
        }
    
        $date = Date::where('namegekochtid', $id)->first();
    
        if ($date && $date->namegekochtid == $id) {
            $date->update(['namegekocht' => $attributes['name']]);
        }
    
        return redirect('Namen');
    }
    
    
}
/*DB::insert('insert into names (id, name) values (?, ?)', [$id, $name]);//wie dass immer in neue spalte*/