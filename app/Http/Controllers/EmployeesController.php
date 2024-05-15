<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Models\Employee;
use App\Models\Date;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class EmployeesController extends Controller
{
    /**
     * Function to display the employee profile image
     *
     * @param string $filePath The name of the file
     *
     */
    public function displayImage($filePath)
    {
        // Get the full path to the image file
        $imagePath = storage_path('app/' . $filePath);

        // Check if the file exists
        if (!file_exists($imagePath)) {
            abort(404);
        }

        // Determine the content type of the file
        $contentType = mime_content_type($imagePath);

        // Set headers based on the content type
        $headers = [
            'Content-Type' => $contentType,
        ];

        // Return the response with the file and headers
        return response()->file($imagePath, $headers);
    }

    /**
     * Function to list all employees
     */
    public function list()
    {
        // Order by the last name of Employee and adding a simplePaginate (max 8 employees for page)
        $employees = Employee::where('still_working', 1)
            ->orderByRaw("SUBSTRING_INDEX(name, ' ', -1)")
            ->simplePaginate(8);

        return view('Names', ['names' => $employees]);
    }

    /**
     * Function to store the new employee
     *
     * @param Request $request
     */
    public function store(Request $request) // Neuen Eintrag in Datenbank
    {
        // Validate
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:35',
            ],
        ]);
        if ($validator->fails()) {
            return redirect('Namen')->withErrors(['eingabe' => 'Feld darf nicht leer sein und maximal 35 Zeichen haben']);
            // ->withErrors($validator);
        }
        $validated = $validator->validated();
        Employee::create($validated);
        return redirect('Namen');
    }

    /**
     * Function to update an employee
     *
     * @param int $id The employee's id
     * @param Request $request
     *
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:35'],
        ]);

        if ($validator->fails()) {
            return redirect('Namen')->withErrors([$id => 'Feld darf nicht leer sein und maximal 35 Zeichen haben']);
        }

        $validated = $validator->validated();

        try {
            DB::beginTransaction();

            // Aktualisieren Sie die Daten in der Mitarbeitertabelle
            $employee = Employee::find($id);
            $employee->name = $validated['name'];
            $employee->is_available = $request->is_available == null ? 1 : 0;
            $employee->save();

            // Rufen Sie Datensätze aus der Tabelle „Datum“ nach ID ab und aktualisieren Sie deren Namen
            $dates = Date::where('namepraesentiertid', $id)
                ->orWhere('namegekochtid', $id)
                ->get();

            foreach ($dates as $date) {
                if ($date->namepraesentiertid == $id) {
                    $date->update(['namepraesentiert' => $validated['name']]);
                }

                if ($date->namegekochtid == $id) {
                    $date->update(['namegekocht' => $validated['name']]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('Namen')->withErrors([$id => 'Fehler beim Speichern der Daten. Bitte versuchen Sie es erneut.']);
        }

        return redirect('Namen');
    }


    /**
     * Function to 'delete' an employee
     *
     * @param int $id The employee's id
     *
     */
    public function delete($id)
    {

        $employee = Employee::find($id);
        if (File::exists(storage_path('/app/public/' . $employee->file_hash))) { // Delete profile picture with
            File::delete(storage_path('/app/public/' . $employee->file_hash));
        }

        $employee->still_working = 0; // Set the employee to disabled (This is to use the employee in the recipes even if it is 'deleted')
        $employee->save();

        return redirect('Namen');
    }

    /**
     * Generator page function
     */
    public function home()
    {
        $datum = Carbon::now()->format('d.m.Y');
        session()->forget('showRegenerateButton');
        return view('home', ['random1' => null, 'random2' => null, 'datum' => $datum]);
    }

    /**
     * Function to generate 2 random employees, one for cooking and other for present
     *
     * @param Request $request
     */
    public function random(Request $request) // möglichst zufällig jemanden auswählen
    {
        $validator = Validator::make($request->all(), [
            'date' => ['required', 'max:10', 'date'],
        ]);
        if ($validator->fails()) {
            return redirect('/')->withErrors(['date' => 'ungültiges Datum']);
        }

        $employeesForPresentation = Employee::where('praesentiert', false)
            ->where('is_available', true)
            ->where('still_working', true)
            ->get();
        $employeesForCooking = Employee::where('gekocht', false)
            ->where('is_available', true)
            ->where('still_working', true)
            ->get();

        // If there are not enough people to present or prepare, reset all values
        if (((count($employeesForPresentation) === 1 && count($employeesForCooking) === 1) &&
                ($employeesForPresentation->first()->id === $employeesForCooking->first()->id))
            || (count($employeesForPresentation) < 1 || count($employeesForCooking) < 1)
        ) {
            Employee::query()->update(['praesentiert' => false, 'gekocht' => false]);
            $employeesForPresentation = Employee::where('praesentiert', false)
                ->where('is_available', true)
                ->where('still_working', true)
                ->get();
            $employeesForCooking = Employee::where('gekocht', false)
                ->where('is_available', true)
                ->where('still_working', true)
                ->get();
        }

        // Selection of random employees for presentation and preparation (it cannot be the same employee)
        $randomPresentationEmployee = $employeesForPresentation->random();
        do {
            $randomCookingEmployee = $employeesForCooking->random();
        } while ($randomPresentationEmployee->id == $randomCookingEmployee->id);

        // Setting the checkboxes “presented” and “cooked” for the selected employees

        $randomPresentationEmployee->update(['praesentiert' => true]);
        $randomCookingEmployee->update(['gekocht' => true]);

        // Creating a record in the database
        Date::create([
            'date' => Carbon::createFromFormat('d.m.Y', $request->date)->toDateString(),
            'namepraesentiert' => $randomPresentationEmployee->name,
            'namegekocht' => $randomCookingEmployee->name,
            'namepraesentiertid' => $randomPresentationEmployee->id,
            'namegekochtid' => $randomCookingEmployee->id,
        ]);

        // Setting a session variable to display the Regenerate button
        session(['showRegenerateButton' => true]);

        // Return a response with the view and required data
        return view('home', [
            'random1' => $randomPresentationEmployee,
            'random2' => $randomCookingEmployee,
            'datum' => $request->date,
        ]);
    }

    /**
     * Function to regenerate the 2 employees if the first generation has not been to your liking
     *
     * @param Request $request
     */
    public function regenerateData(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'date' => ['required', 'date_format:d.m.Y'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $random1 = Employee::where('praesentiert', false)
            ->where('is_available', true)
            ->where('still_working', true)
            ->inRandomOrder()
            ->first();
        if ($random1 == null) { // when everyone has presented
            $employeesAll = Employee::all();
            for ($i = 0; $i < count($employeesAll); $i++) { //  when everyone has presented, set everything to false again
                $employeesAll[$i]->praesentiert = false;
                $employeesAll[$i]->save();
            }
        }

        do {
            $random2 = Employee::where('gekocht', false)
                ->where('is_available', true)
                ->where('still_working', true)
                ->inRandomOrder()
                ->first();
        } while ($random1->id == $random2->id);

        if ($random2 == null || $random2 == $random1) {
            $employeesAll = Employee::all();
            for ($i = 0; $i < count($employeesAll); $i++) {
                $employeesAll[$i]->gekocht = false;
                $employeesAll[$i]->save();
            }
        }

        // Check whether new employees can be found
        if (!$random1 || !$random2) {
            return redirect()->back()->withErrors(['date' => 'Es konnten keine neuen Mitarbeiter gefunden werden']);
        }

        $latestDate = Date::latest('id')->first();

        // Check if the latest date exists
        if (!$latestDate) {
            return redirect()->back()->withErrors(['date' => 'Kein vorheriges Datum gefunden']);
        }

        // Update previous employee data to false
        $praesentiertEmployee = Employee::find($latestDate->namepraesentiertid);
        $gekochtEmployee = Employee::find($latestDate->namegekochtid);
        $praesentiertEmployee->praesentiert = false;
        $gekochtEmployee->gekocht = false;
        $praesentiertEmployee->save();
        $gekochtEmployee->save();

        $random1->praesentiert = true;
        $random1->save();
        $random2->gekocht = true;
        $random2->save();

        $latestDate->update([
            'namepraesentiert' => $random1->name,
            'namegekocht' => $random2->name,
            'namepraesentiertid' => $random1->id,
            'namegekochtid' => $random2->id,
        ]);

        return view('home', ['random1' => $random1, 'random2' => $random2, 'datum' => $request->date]);
    }


    /**
     * Upload profile picture function
     *
     * @param int $id The employee's id
     * @param Request $request
     *
     */
    public function upload($id, Request $request) //Profilbild hochladen
    {
        $employee = Employee::find($id);

        $file = $request->file('file');
        if ($file == null) {
            return redirect()->back();
        }
        if (File::exists(storage_path('/' . $employee->file_hash))) { //altes löschen
            File::delete(storage_path('/' . $employee->file_hash));
        }

        $hash = $file->hashName(); //hash erstellen falls 2mal gleicher file name mit unterschiedlichen bildern
        $employee->file_hash = "{$hash}";
        $employee->file_name = $file->getClientOriginalName();
        $employee->mime_type = $file->getClientMimeType();
        $employee->path = $request->file('file')->store('/');
        $employee->size = $file->getSize();
        $employee->save();

        return redirect()->back();
    }
}
