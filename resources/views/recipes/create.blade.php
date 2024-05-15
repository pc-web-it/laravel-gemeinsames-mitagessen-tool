<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gemeinsames Mittagessen Tool - Recipes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="max-w-lg mx-auto mt-8">
        <form action="/recipes" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf

            <x-form-field>

                <x-form-label for="title">Name of Recipe</x-form-label>

                <x-form-input id="title" type="text" name="title" placeholder="Name of Recipe"
                    value="{{ old('title') }}" required />

                <x-form-error name="title" />

            </x-form-field>
            <x-form-field>

                <x-form-label for="description">Description</x-form-label>

                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>

                <x-form-error name="description" />

            </x-form-field>
            <x-form-field>

                <x-form-label for="employee_id">Chef</x-form-label>

                <select
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="employee_id" name="employee_id">
                    <option value="">Select a employee</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }}</option>
                    @endforeach
                </select>

                <x-form-error name="employee_id" />

            </x-form-field>
            <x-form-field>

                <x-form-label for="image">Photo</x-form-label>

                <x-form-input id="image" type="file" name="image" />

                <x-form-error name="image" />

            </x-form-field>
            <x-form-field>

                <x-form-label for="pdf_path">PDF recipe</x-form-label>

                <x-form-input id="pdf_path" type="file" name="pdf_path" />

                <x-form-error name="pdf_path" />

            </x-form-field>
            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Create
                </button>
                <a href="/recipes"
                    class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Go Back
                </a>
            </div>
        </form>
    </div>

</body>

</html>
