<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Date;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class DatesController extends Controller
{
    public function list()
    {
        $employeesKochen = Employee::where('gekocht', false)->orderByRaw("SUBSTRING_INDEX(name, ' ', -1)")->get();
        $employeesPraesentieren = Employee::where('praesentiert', false)->orderByRaw("SUBSTRING_INDEX(name, ' ', -1)")->get();

        $dates = Date::orderByDesc('date')->simplePaginate(5);

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


    public function updateAllDate(Request $request)
    {
        $date = Date::find($request->dateId);

        // Validate
        $request->validate([
            'dateText' => ['required', 'max:10', 'date_format:d.m.Y'],
        ]);

        // Call functions to update the personPraesentieren and Kochen
        $this->updatePersonPraesentieren(request('actualPraesentiertId'), request('praesentiertSelect'), request('dateId'));
        $this->updatePersonKochen(request('actualGekochtId'), request('gekochtSelect'), request('dateId'));

        // Update the date
        $date->date = Carbon::createFromFormat('d.m.Y', request('dateText'))->toDateString();
        $date->save();

        // Return to the form with errors if any
        return redirect('/Verlauf')->withInput();
    }

    public function updatePersonKochen($id1, $id2, $id3)
    {
        $namegekocht = Date::find($id3);
        if ($namegekocht->namepraesentiertid === (int)$id2) {
            return redirect()->back()->withErrors(['error' => 'Wer präsentiert und kocht, kann nicht dieselbe Person sein']);
        }
        $employee1 = Employee::find($id1);
        if ($employee1 != null) {
            $employee1->gekocht = true;
            $employee1->save();
        }

        $employee2 = Employee::find($id2);
        if ($employee2 != null) {
            $employee2->gekocht = false;
            $employee2->save();
        }
        $namegekocht->namegekocht = $employee2->name;
        $namegekocht->namegekochtid = $employee2->id;
        $namegekocht->save();
    }

    public function updatePersonPraesentieren($id1, $id2, $id3)
    {
        $namepraesentiert = Date::find($id3);
        if ($namepraesentiert->namegekochtid === (int)$id2) {
            return redirect()->back()->withErrors(['error' => 'Wer präsentiert und kocht, kann nicht dieselbe Person sein']);
        }
        $employee1 = Employee::find($id1);
        if ($employee1 != null) {
            $employee1->praesentiert = true;
            $employee1->save();
        }

        $employee2 = Employee::find($id2);
        if ($employee2 != null) {
            $employee2->praesentiert = false;
            $employee2->save();
        }

        $namepraesentiert->namepraesentiert = $employee2->name;
        $namepraesentiert->namepraesentiertid = $employee2->id;
        $namepraesentiert->save();
    }

    public function removeSingleEmployee($id, $isGekocht)
    {
        $date = Date::find($id);

        if ($isGekocht) {
            $date->namegekocht = '';
            $date->namegekochtid = null;
        } elseif (!$isGekocht) {
            $date->namepraesentiert = '';
            $date->namepraesentiertid = null;
        }
        $date->save();

        return redirect()->back();
    }

    public function updateDate($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => [
                'required', 'max:10', 'date_format:d.m.Y',
            ],
        ]);
        if ($validator->fails()) {
            return redirect('Verlauf')->withErrors([$id => 'ungültiges Datum']);
        }

        $date = Date::find($id);
        $date->date = Carbon::createFromFormat('d.m.Y', $request->date)->toDateString();
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
