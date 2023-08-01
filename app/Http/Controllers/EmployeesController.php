<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Models\Employee;
use App\Models\Date;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class EmployeesController extends Controller
{
    public function displayImage($fileName)
    {

        $imagePath = storage_path('app/' . $fileName);

        $headers = [
            'Content-Type' => 'image/jpeg',
        ];

        return Response::file($imagePath, $headers);


    }

    public function list()
    {
        $employees = Employee::all();




        return view('Names', ['names' => $employees]);
    }
    public function create()
    {
        return view('Names');
    }
    public function store(Request $request) //Neuen Eintrag in Datenbank
    {
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
    public function update($id, Request $request) //Namen updaten
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:35',
            ],
        ]);
        if ($validator->fails()) {
            return redirect('Namen')->withErrors([$id => 'Feld darf nicht leer sein und maximal 35 Zeichen haben']);
            // ->withErrors($validator);
        }
        $validated = $validator->validated();
        $employee = Employee::find($id);
        $employee->name = $validated['name'];
        $employee->save();
        return redirect('Namen');
    }

    public function delete($id) //Person löschen
    {

        $employee = Employee::find($id);
        if (File::exists(storage_path('/app/public/' . $employee->file_hash))) { //Profilbild mit löschen
            File::delete(storage_path('/app/public/' . $employee->file_hash));

        }
        $employee->delete();
        return redirect('Namen');
    }

    public function home()
    {
        $datum = Carbon::now()->format('d.m.Y');
        return view('home', ['random1' => null, 'random2' => null, 'datum' => $datum]);
    }
    public function random(Request $request) //möglichst zufällig jemanden auswählen
    {
        $validator = Validator::make($request->all(), [
            'date' => ['required', 'max:10', 'date'],
        ]);
        if ($validator->fails()) {
            return redirect('/')->withErrors(['date' => 'ungültiges Datum']);

        }
        $validated = $validator->validated();


        $datum = Carbon::now()->format('d.m.Y');
        $random1 = Employee::where('praesentiert', false) //random jemanden zum präsentieren auswählen
            ->inRandomOrder()
            ->first();
        if ($random1 == null) { //wenn alle praesentiert haben
            $employeesAll = Employee::all();
            for ($i = 0; $i < count($employeesAll); $i++) { //wenn alle praesentiert haben wieder alles auf false setzen
                $employeesAll[$i]->praesentiert = false;
                $employeesAll[$i]->save();
            }

        }

        $random2 = Employee::where('gekocht', false) //gleiches prinzip (nicht in einer schleife gemeinsam falls personen aus der Datenbank gelöscht werden)
            ->inRandomOrder()
            ->first();
        if ($random2 == null) {
            $employeesAll = Employee::all();
            for ($i = 0; $i < count($employeesAll); $i++) {
                $employeesAll[$i]->gekocht = false;
                $employeesAll[$i]->save();
            }

        }

        $employees1 = Employee::where('praesentiert', false)->get(); //alle die noch praesentieren muessen werden ausgewaehlt
        if (count($employees1) == 2) { /*das ziel dieser if bedingung ist, dass nicht beim letzten durchgang einer übrig bleibt der praesentieren und kochen muss 
und dass Programm sich aufhängen würde, im prinzip wird beim Vorletzten durchgang überprüft ob bestimmte Personen noch praesentieren und kochen muessen
und diese werden dann zum praesentieren oder kochen ausgewaehlt*/
            if ($employees1[0]->gekocht == false) { //wenn jemand noch nicht praesentiert und gekocht hat muss er praesentieren
                $employees1[0]->praesentiert = true;
                $employees1[0]->save();

                if ($employees1[1]->gekocht == false) { //wenn eine zweite Person noch praesentieren und kochen muss wird diese ausgewählt
                    $employees1[1]->gekocht = true;
                    $employees1[1]->save();
                    Date::create(['date' => Arr::first($validated), 'namepraesentiert' => $employees1[0]->name, 'namegekocht' => $employees1[1]->name, 'namepraesentiertid' => $employees1[0]->id, 'namegekochtid' => $employees1[1]->id]);
                    return view('home', ['random1' => $employees1[0], 'random2' => $employees1[1], 'datum' => $request->date]);
                } else {
                    $counter1 = 0;
                    do {
                        $random3 = Employee::where('gekocht', false) //vermutilch eh nur eine moegliche Person aber wenn Personen aus der Datenbank entfert werden die bisher nur Praesentiert haben, dann macht diese auswahl sinn
                            ->inRandomOrder()
                            ->first();
                        $counter1++;
                        if ($counter1 > 9) { //wenn 2 noch praesentieren müssen und 1 noch kochen muss dann kann diese Schleife loopen deshalb dieser Code hier
                            $employees1[0]->gekocht = true;
                            $employees1[0]->praesentiert = false;
                            $employees1[0]->save();
                            $employees1[1]->praesentiert = false;
                            $employees1[1]->save();
                            Date::create(['date' => Arr::first($validated), 'namepraesentiert' => $employees1[1]->name, 'namegekocht' => $employees1[0]->name, 'namepraesentiertid' => $employees1[1]->id, 'namegekochtid' => $employees1[0]->id]);
                            return view('home', ['random1' => $employees1[1], 'random2' => $employees1[0], 'datum' => $request->date]);
                        }

                    } while ($random3->id == $employees1[0]->id); //dass nicht die gleiche Person ausgewählt wird
                    $random3->gekocht = true;
                    $random3->save();
                    Date::create(['date' => Arr::first($validated), 'namepraesentiert' => $employees1[0]->name, 'namegekocht' => $random3->name, 'namepraesentiertid' => $employees1[0]->id, 'namegekochtid' => $random3->id]);
                    return view('home', ['random1' => $employees1[0], 'random2' => $random3, 'datum' => $request->date]);
                }
            }

        }

        $counter = 0;
        do {

            $random1 = Employee::where('praesentiert', false) //zufällig jemanden auswählen der praesentieren muss
                ->inRandomOrder()
                ->first();

            $random2 = Employee::where('gekocht', false) //zufällig jemanden auswählen der kochen muss 
                ->inRandomOrder()
                ->first();


            $counter++;
            if ($counter > 9) { //wenn eine person hinzugefügt wird wenn alle anderen schon gekocht und Praesentiert haben dann würde diese Schleife loopen deshalb werden alle reseted
                $employeesAll = Employee::all();
                for ($i = 0; $i < count($employeesAll); $i++) {
                    $employeesAll[$i]->gekocht = false;
                    $employeesAll[$i]->praesentiert = false;
                    $employeesAll[$i]->save();
                }
            }
        } while (($random1->id) == ($random2->id));

        $random1->praesentiert = true;
        $random1->save();
        $random2->gekocht = true;
        $random2->save();


        Date::create(['date' => Arr::first($validated), 'namepraesentiert' => $random1->name, 'namegekocht' => $random2->name, 'namepraesentiertid' => $random1->id, 'namegekochtid' => $random2->id]);
        return view('home', ['random1' => $random1, 'random2' => $random2, 'datum' => $request->date]);
        /*ein Code der sicher funktioniert falls der obere nicht funktionieren sollte*/
        /*
        $counter = 0;
        do {

            $random1 = Name::where('praesentiert', false) 
                ->inRandomOrder()
                ->first();
            if ($random1 == null) { 
                $names = Name::all();
                for ($i = 0; $i < count($names); $i++) { 
                    $names[$i]->praesentiert = false;
                    $names[$i]->save();
                }
                $random1 = Name::where('praesentiert', false) 
                    ->inRandomOrder()
                    ->first();
            }
            $random2 = Name::where('gekocht', false) 
                ->inRandomOrder()
                ->first();
            if ($random2 == null) {
                $names = Name::all();
                for ($i = 0; $i < count($names); $i++) {
                    $names[$i]->gekocht = false;
                    $names[$i]->save();
                }
                $random2 = Name::where('gekocht', false)
                    ->inRandomOrder()
                    ->first();
            }

            $counter++;
            if ($counter > 3) {
                $names = Name::all();
                for ($i = 0; $i < count($names); $i++) {
                    $names[$i]->gekocht = false;
                    $names[$i]->praesentiert = false;
                    $names[$i]->save();
                }
            }
        } while (($random1->id) == ($random2->id));

        $random1->praesentiert = true;
        $random1->save();
        $random2->gekocht = true;
        $random2->save();
        $random1 = $random1->name;
        $random2 = $random2->name;
        return view('home', ['random1' => $random1, 'random2' => $random2]);*/
    }

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