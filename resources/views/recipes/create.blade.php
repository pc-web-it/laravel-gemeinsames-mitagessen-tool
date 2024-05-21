<x-layout>
    <div class="max-w-lg mx-auto mt-8">
        <form action="/recipes" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">

            <h1 class="neuesRezeptTitel text-center md:text-xl mt-5" style="font-size: 2rem;">Neues Rezept</h1>

            @csrf

            <x-form-field>

                <x-form-label for="title">Rezeptname</x-form-label>

                <x-form-input id="title" type="text" name="title" placeholder="Name of Recipe"
                    value="{{ old('title') }}" required />

                <x-form-error name="title" />

            </x-form-field>
            <x-form-field>

                <x-form-label for="description">Beschreibung</x-form-label>

                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>

                <x-form-error name="description" />

            </x-form-field>
            <x-form-field>

                <x-form-label for="employee_id">Gekocht</x-form-label>

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

                <x-form-label for="image">Foto</x-form-label>

                <x-form-input id="image" type="file" name="image" />

                <x-form-error name="image" />

            </x-form-field>
            <x-form-field>

                <x-form-label for="pdf_path">PDF Rezept</x-form-label>

                <x-form-input id="pdf_path" type="file" name="pdf_path" />

                <x-form-error name="pdf_path" />

            </x-form-field>
            <div class="flex items-center justify-between mt-5">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline"
                    type="submit">
                    Speichern
                </button>
                <a href="/recipes"
                    class="backBtn inline-block align-baseline font-bold text-sm py-2 px-3"><img src="{{ asset('back2.jpg') }}" alt="Back" class="w-6 inline mr-2 mb-1">
                    Zurück
                </a>
            </div>
        </form>
    </div>

</x-layout>
