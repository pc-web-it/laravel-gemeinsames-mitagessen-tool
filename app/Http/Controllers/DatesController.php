<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Date;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class DatesController extends Controller
{
    public function list() {
        $employeesKochen = Employee::where('gekocht', false)->orderByRaw("SUBSTRING_INDEX(name, ' ', -1)")->get();
        $employeesPraesentieren = Employee::where('praesentiert', false)->orderByRaw("SUBSTRING_INDEX(name, ' ', -1)")->get();
        $dates = Date::orderBy(DB::raw("STR_TO_DATE(date, '%d.%m.%Y')"), 'desc')->simplePaginate(5);

        // Wir erstellen Sammlungen von Ausweisen von Mitarbeitern, die zu bestimmten Terminen bereits teilgenommen haben
        $employeeIdsInGekochtDates = $dates->pluck('namegekochtid')->filter();
        $employeeIdsInPraesentiertDates = $dates->pluck('namepraesentiertid')->filter();

        // Wir filtern Mitarbeiter, die zu bestimmten Terminen bereits teilgenommen haben
        $employeesKochen = $employeesKochen->reject(function ($employee) use ($employeeIdsInGekochtDates) {
            return $employeeIdsInGekochtDates->contains($employee->id);
        });

        $employeesPraesentieren = $employeesPraesentieren->reject(function ($employee) use ($employeeIdsInPraesentiertDates) {
            return $employeeIdsInPraesentiertDates->contains($employee->id);
        });

        return view('Dates', ['dates' => $dates, 'personenKochen' => $employeesKochen, 'personenPraesentieren' => $employeesPraesentieren]);
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
            'date' => ['required', 'max:10',
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

    public function deleteDate($id)
    {
        $date = Date::find($id);

        if (!$date) {
            return redirect()->back()->with('error', 'Objekt nicht gefunden.');
        }

        // Wir erhalten Ausweise von Mitarbeitern, die in den Spalten „praesentiert“ und „gekocht“ aufgeführt sind
        $praesentiertId = $date->namepraesentiertid;
        $gekochtId = $date->namegekochtid;

        // Wir rufen Mitarbeiter anhand ihrer ID aus der Tabelle „employees“ ab
        $praesentiertEmployee = Employee::find($praesentiertId);
        $gekochtEmployee = Employee::find($gekochtId);

        if ($praesentiertEmployee && $gekochtEmployee) {
            $praesentiertEmployee->praesentiert = 0;
            $gekochtEmployee->gekocht = 0;

            $praesentiertEmployee->save();
            $gekochtEmployee->save();
        }

        $date->delete();

        return redirect()->back()->with('success', 'Objekt erfolgreich gelöscht.');
    }


}
