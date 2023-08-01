<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Date;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

class DatesController extends Controller
{
    public function list () {
        
        $employeesKochen = Employee::where('gekocht', false)->get();

        $employeesPraesentieren = Employee::where('praesentiert', false)->get();
        
        
        $dates = Date::all();
        
        return view('Dates', ['dates' => $dates->reverse(), 'personenKochen' => $employeesKochen, 'personenPraesentieren' => $employeesPraesentieren]);
    }
    
    public function updatePersonKochen($id1, $id2, $id3){
        
        $employee1 = Employee::find($id1);
        $employee1->gekocht = true;
        $employee1->save();
        $employee2 = Employee::find($id2);
        
        if($employee2!=null){
            $employee2->gekocht = false;
            $employee2->save();
            
        }
        $namegekocht = Date::find($id3);
        $namegekocht->namegekocht = $employee1->name;
        $namegekocht->namegekochtid = $employee1->id;
        $namegekocht->save();
        return redirect()->back();
    }
    public function updatePersonPraesentieren($id1, $id2, $id3){
        
        $employee1 = Employee::find($id1);
        $employee1->praesentiert = true;
        $employee1->save();
        $employee2 = Employee::find($id2);
        
        if($employee2!=null){
            $employee2->praesentiert = false;
            $employee2->save();
            
        }
        $namepraesentiert = Date::find($id3);
        $namepraesentiert->namepraesentiert = $employee1->name;
        $namepraesentiert->namepraesentiertid = $employee1->id;
        $namepraesentiert->save();
        return redirect()->back();
    }
    public function updateDate($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:35',
            ],
        ]);
        if ($validator->fails()) {
            return redirect('Verlauf')->withErrors([$id => 'ungültiges Datum']);
        }

        $date = Date::find($id);
        $date->date = $request->date;
        $date->save();
        return redirect()->back();
    }
    
}
