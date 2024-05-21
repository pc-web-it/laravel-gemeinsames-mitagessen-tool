<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;

class RecipesController extends Controller
{
    /**
     * Function to show the list of recipes
     */
    public function index()
    {
        // Get the recipes filter by the lastest created/updated and using pagination
        $recipes = Recipe::latest()->simplePaginate(10);
        $employees = Employee::all();

        return view('recipes.index', [
            'recipes' => $recipes,
            'employees' => $employees,
        ]);
    }

    /**
     * Function to redirect to the create view
     */
    public function create()
    {
        $employees = Employee::all();
        return view('recipes.create', [
            'employees' => $employees,
        ]);
    }

    /**
     * Function to show a single recipe
     *
     * @param Recipe $recipe The recipe we want to see
     */
    public function show(Recipe $recipe)
    {
        $employee = Employee::find($recipe->employee_id);
        return view('recipes.show', [
            'recipe' => $recipe,
            'employee' => $employee,
        ]);
    }

    /**
     * Function to store a new recipe
     */
    public function store()
    {
        // Validate
        request()->validate([
            'title' => ['required', 'min:3'],
            'employee_id' => ['required', 'exists:employees,id'],
            'image' => ['nullable',
                File::image()
                    ->max(2048),
                ],
            'pdf_path' => ['nullable',
                File::types('pdf')
                    ->max(2048),
                ],
        ]);

        // Save image logic
        $pathImg = null;

        if (request()->hasFile('image')) {

            $imageFile = request()->file('image');

            $fileName = uniqid() . '_' . $imageFile->getClientOriginalName();

            $imageFile->storeAs('recipesImages', $fileName);

            $pathImg = $fileName;
        }

        $recipe = new Recipe(); // Create the new recipe

        if (request()->hasFile('pdf_path')) {
            // Obtein the pdf file of request
            $pdfFile = request()->file('pdf_path');

            // Generate unique name for the file
            $fileName = uniqid() . '_' . $pdfFile->getClientOriginalName();

            // Save the file in the storage
            $pdfFile->storeAs('pdfs', $fileName);

            $recipe->pdf_path = $fileName;
        }

        $recipe->title = request()->title;
        if(request()->description) {
            $recipe->description = request()->description;
        }
        $recipe->employee_id = request()->employee_id;
        $recipe->image = $pathImg;

        // Save the recipe
        $recipe->save();

        return redirect('/recipes');
    }

    /**
     * Function to redirect to the edit view
     *
     * @param Recipe $recipe The recipe we want to update
     */
    public function edit(Recipe $recipe)
    {
        $employees = Employee::all();
        return view('recipes.edit', [
            'recipe' => $recipe,
            'employees' => $employees
        ]);
    }

    /**
     * Function to update the recipe
     *
     * @param Recipe $recipe
     */
    public function update(Recipe $recipe)
    {
        // Validation
        request()->validate([
            'title' => ['required', 'min:3'],
            'employee_id' => ['required', 'exists:employees,id'],
            'image' => ['nullable',
                File::image()
                    ->max(2048),
                ],
            'pdf_path' => ['nullable',
                File::types('pdf')
                    ->max(2048),
                ],
        ]);


        // Upload the recipe image
        if (request()->hasFile('image')) {
            $imageFile = request()->file('image');

            $fileName = uniqid() . '_' . $imageFile->getClientOriginalName();

            $imageFile->storeAs('recipesImages', $fileName);

            $recipe->image = $fileName;
        }

        if (request()->hasFile('pdf_path')) {
            // Obtein the pdf file of request
            $pdfFile = request()->file('pdf_path');

            // Generate unique name for the file
            $fileName = uniqid() . '_' . $pdfFile->getClientOriginalName();

            // Save the file in the storage
            $pdfFile->storeAs('pdfs', $fileName);

            $recipe->pdf_path = $fileName;
        }

        $recipe->title = request()->title;
        $recipe->description = request()->description;
        $recipe->employee_id = request()->employee_id;


        // Save the recipe
        $recipe->save();

        return redirect('/recipes/' . $recipe->id);
    }

    /**
     * Function to delete the recipe
     *
     * @param Recipe $recipe The recipe to delete
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return redirect('/recipes');
    }

    /**
     * Function to display the recipe image
     *
     * @param string $filePath The recipe image path
     */
    public function displayRecipeImage($filePath)
    {
        // Get the full path to the image file
        $path = storage_path('app/recipesImages/' . $filePath);

        // Check if the file exists
        if (!file_exists($path)) {
            abort(404);
        }

        // Determine the content type of the file
        $contentType = mime_content_type($path);

        // Set headers based on the content type
        $headers = [
            'Content-Type' => $contentType,
        ];

        // Return the response with the file and headers
        return response()->file($path, $headers);
    }

    /**
     * Function to display the recipe pdf
     *
     * @param string $filePath The recipe pdf path
     */
    public function displayPdf($filePath)
    {
        // Get the full path to the pdf file
        $imagePath = storage_path('app/pdfs/' . $filePath);

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
}
