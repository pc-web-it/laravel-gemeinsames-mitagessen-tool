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
    /**
     * Function to list all dates
     */
    public function list()
    {
        $employeesKochen = Employee::where('gekocht', false)->orderByRaw("SUBSTRING_INDEX(name, ' ', -1)")->get();
        $employeesPraesentieren = Employee::where('praesentiert', false)->orderByRaw("SUBSTRING_INDEX(name, ' ', -1)")->get();

        // We declare the dates variable ordered by the most recent and add the pagination
        $dates = Date::orderByDesc('date')->simplePaginate(5);

        // We create collections of ID cards from employees who have already attended certain dates
        $employeeIdsInGekochtDates = $dates->pluck('namegekochtid')->filter();
        $employeeIdsInPraesentiertDates = $dates->pluck('namepraesentiertid')->filter();

        // We filter employees who have already attended certain dates
        $employeesKochen = $employeesKochen->reject(function ($employee) use ($employeeIdsInGekochtDates) {
            return $employeeIdsInGekochtDates->contains($employee->id);
        });

        $employeesPraesentieren = $employeesPraesentieren->reject(function ($employee) use ($employeeIdsInPraesentiertDates) {
            return $employeeIdsInPraesentiertDates->contains($employee->id);
        });

        return view('Dates', ['dates' => $dates, 'personenKochen' => $employeesKochen, 'personenPraesentieren' => $employeesPraesentieren]);
    }


    /**
     * Function to update all Date
     *
     * @param Request $request Request received
     * @return
     */
    public function updateAllDate(Request $request)
    {
        $date = Date::find($request->dateId);

        // Validate
        $request->validate([
            'dateText' => ['required', 'max:10', 'date_format:d.m.Y'],
            'rezeptSelect' => ['required']
        ]);

        // Call functions to update the personPraesentieren and Kochen
        $this->updatePersonPraesentieren(request('actualPraesentiertId'), request('praesentiertSelect'), request('dateId'));
        $this->updatePersonKochen(request('actualGekochtId'), request('gekochtSelect'), request('dateId'));

        // Update the date
        $date->date = Carbon::createFromFormat('d.m.Y', request('dateText'))->toDateString();
        $date->save();

        // Return to the form
        return redirect('/Verlauf')->withInput();
    }

    /**
     * Funcion to change the person who cooks
     *
     * @param int $id1 The old person id who cooks
     * @param int $id2 The new person id who cooks
     * @param int $id3 The date id
     *
     */
    public function updatePersonKochen($id1, $id2, $id3)
    {
        $namegekocht = Date::find($id3);

        // Make sure the person presenting is not the same
        if ($namegekocht->namepraesentiertid === (int)$id2) {
            return redirect()->back()->withErrors(['error' => 'Wer präsentiert und kocht, kann nicht dieselbe Person sein']);
        }

        // Make sure the old employee exists
        $employee1 = Employee::find($id1);
        if ($employee1 != null) {
            $employee1->gekocht = true;
            $employee1->save();
        }

        // Make sure the new employee exists
        $employee2 = Employee::find($id2);
        if ($employee2 != null) {
            $employee2->gekocht = false;
            $employee2->save();
        }

        // Add the data and save it to the database
        $namegekocht->namegekocht = $employee2->name;
        $namegekocht->namegekochtid = $employee2->id;
        $namegekocht->save();
    }


    /**
     * Function to change the person who present
     *
     * @param int $id1 The old person id who presents
     * @param int $id2 The new person id who presents
     * @param int $id3 The date id
     *
     */
    public function updatePersonPraesentieren($id1, $id2, $id3)
    {
        $namepraesentiert = Date::find($id3);

        // Make sure the person cooking is not the same
        if ($namepraesentiert->namegekochtid === (int)$id2) {
            return redirect()->back()->withErrors(['error' => 'Wer präsentiert und kocht, kann nicht dieselbe Person sein']);
        }

        // Make sure the old employee exists
        $employee1 = Employee::find($id1);
        if ($employee1 != null) {
            $employee1->praesentiert = true;
            $employee1->save();
        }

        // Make sure the new employee exists
        $employee2 = Employee::find($id2);
        if ($employee2 != null) {
            $employee2->praesentiert = false;
            $employee2->save();
        }

        // Add the data and save it to the database
        $namepraesentiert->namepraesentiert = $employee2->name;
        $namepraesentiert->namepraesentiertid = $employee2->id;
        $namepraesentiert->save();
    }

    /**
     * Function to remove an employee from date
     *
     * @param int $id The employee id
     * @param bool $isGekocht Indicates if that employee is cooking or presenting
     */
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

    /**
     * Function to update only the date
     *
     * @param int $id The date id
     * @param Request $request The request param
     *
     */
    public function updateDate($id, Request $request)
    {
        // Validate
        $validator = Validator::make($request->all(), [
            'date' => [
                'required', 'max:10', 'date_format:d.m.Y',
            ],
        ]);

        // If its fails return to the page with the validation error
        if ($validator->fails()) {
            return redirect('Verlauf')->withErrors([$id => 'ungültiges Datum']);
        }

        // If validation pass we find the date with id and we update it
        $date = Date::find($id);
        $date->date = Carbon::createFromFormat('d.m.Y', $request->date)->toDateString();
        $date->save();

        // Return to the Verlauf page
        return redirect()->back();
    }

    /**
     * Function to delete the entire Date
     *
     * @param int $id Date id
     */
    public function deleteDate($id)
    {
        $date = Date::find($id);

        if (!$date) {
            return redirect()->back()->with('error', 'Objekt nicht gefunden.');
        }

        // We receive passes from employees listed in the “presented” and “cooked” columns
        $praesentiertId = $date->namepraesentiertid;
        $gekochtId = $date->namegekochtid;

        // We retrieve employees from the employees table by their ID
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
