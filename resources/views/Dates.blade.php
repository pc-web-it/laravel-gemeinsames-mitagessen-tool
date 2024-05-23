<x-layout>


    <div class="containerVerlauf pt-16 lg:pt-2">
        <h1 class="verlaufTitel text-center md:text-xl mt-5 mb-5" style="font-size: 2rem;">Verlauf</h1>

        @foreach ($dates as $date)
            <div
                class="text-center grid grid-cols-1">
                <div class="flex justify-between items-center">
                    <form action="/DateUpdate/{{ $date->id }}" method="GET" name="dateUpdate">
                        @csrf
                        @method('PUT')
                        <h1 class="text-left ml-2 font-sans text-xl font-medium mt-4">
                            Datum:
                            <input type="text" value="{{ Carbon\Carbon::parse($date->date)->format('d.m.Y') }}"
                                name="date" class=" w-28 rounded-full text-center w-32 py-1" />
                            <button name="btnSub" class="mr-2 hidden">
                                <img src="Save.png" alt="" class="w-5 h-5 opacity-40 hover:opacity-50">
                            </button>
                            <div class="text-sm text-red-700 ">
                                @if ($errors->any())
                                    {{ $errors->first($date->id) }}
                                @endif
                            </div>
                        </h1>
                    </form>

              

                    <div class="grid grid-cols-2">

                        <button type="button"
                            onclick="showAlert( {{ $date->id }}, '{{ Carbon\Carbon::parse($date->date)->format('d.m.Y') }}',
                        '{{ $date->namepraesentiertid }}', '{{ $date->namepraesentiert }}',
                        '{{ $date->namegekochtid }}', '{{ $date->namegekocht }}',
                        '{{ $date->recipe_id }}' )"
                            class="text-left ml-2 mr-2 mb-2 font-sans text-xl font-medium mt-4">
                            <img src="pencil.png" alt="editImg" class="w-5 h-5 opacity-40 hover:opacity-50">
                        </button>

                        <form action="{{ route('date.destroy', $date->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="text-left ml-2 mr-2 font-sans text-xl font-medium mt-4">
                                <img src="Delete.png" alt="" class="w-5 h-5 opacity-40 hover:opacity-50">
                            </button>
                        </form>
                    </div>

                </div>
                <div
                    class="font-sans text-lg font-normal relative flex-wrap flex md:flex-col lg:flex-row justify-between md:space-y-6 lg:space-y-0 md:space-x-0 lg:space-x-6 md:space-x-6 m-3 p-3 rounded-2xl bg-gray-50 drop-shadow-xl hover:scale-105 ease-in-out duration-300">



                <div class="flex items-center justify-center  ">
                    <h2 class="col-span-2 mt-5">Praesentiert:</h2>

                    <div class="col-span-2 mt-5">
                        <div class="flex items-center">
                            @if (isset($date->praesentiert->file_hash))
                                @if ($date->praesentiert->file_hash == null)
                                    <img src="Profil.jpg" alt="" class="ml-8 w-9 h-9 rounded-full z-10">
                                @else
                                    <img src="{{ route('display.image', $date->praesentiert->file_hash) }}"
                                        alt="" class="ml-8 w-9 h-9 rounded-full object-cover">
                                @endif
                            @else
                                <img src="Profil.jpg" alt="" class="ml-8 w-9 h-9 rounded-full z-10">
                            @endif
                            <div class="ml-10 mr-2">
                                {{ $date->namepraesentiert }}
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('date.removeEmployee', ['id' => $date->id, 'isGekocht' => 0]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <button type="submit">
                            <img src="Delete.png" alt="deleteImg"
                                class="w-5 h-5 mt-7 col-span-1 opacity-40 hover:opacity-60 cursor-pointer" />
                        </button>
                    </form>
                    </div>

                <div class="flex items-center">
                    <h2 class="col-span-2 mt-5">Gekocht:</h2>

                    <div class="col-span-2 mt-5">
                        <div class="flex items-center">
                            @if (isset($date->gekocht->file_hash))
                                @if ($date->gekocht->file_hash == null)
                                    <img src="Profil.jpg" alt="" class="ml-8 w-9 h-9 rounded-full z-10">
                                @else
                                    <img src="{{ route('display.image', $date->gekocht->file_hash) }}" alt=""
                                        class="ml-8 w-9 h-9 rounded-full object-cover">
                                @endif
                            @else
                                <img src="Profil.jpg" alt="" class="ml-8 w-9 h-9 rounded-full z-10">
                            @endif
                            <div class="ml-10  mr-2">
                                {{ $date->namegekocht }}
                            </div>
                        </div>

                      
                    </div>

                    <form action="{{ route('date.removeEmployee', ['id' => $date->id, 'isGekocht' => 1]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <button type="submit">
                            <img src="Delete.png" alt="deleteImg"
                                class="w-5 h-5 mt-7 col-span-1 opacity-40 hover:opacity-60 cursor-pointer" />
                        </button>
                    </form>

                </div>
                    <!-- place-content-end -->
<!-- grid gap-20 col-span-3 col-start-[5]  mt-10 mb-3  relative flex flex-wrap items-center-->
                    <div class="flex flex-col items-center justify-center  w-full">
                        <div class="max-w-48 border-dotted border-2 border-indigo-600 mt-5">
                            <strong>Rezept verwendet:</strong>
                            @if ($date->recipe_id != null && $date->recipe_id != 0)
                            <a href="/recipes/{{ $date->recipe_id }}" class="flex items-center mt-3 mb-2 ml-2">
                                @if (isset(App\Models\Recipe::find($date->recipe_id)->image))
                                    @if (App\Models\Recipe::find($date->recipe_id)->image == null)
                                        <img src="{{ asset('recipesImages/defaultFood.jpg') }}" alt=""
                                            class="w-12 h-12 rounded-lg mr-2">
                                    @else
                                        <img src="{{ route('display.recipeImage', App\Models\Recipe::find($date->recipe_id)->image) }}"
                                            alt="" class="w-12 h-12 rounded-lg mr-2">
                                    @endif
                                @else
                                    <img src="{{ asset('recipesImages/defaultFood.jpg') }}" alt=""
                                        class="w-12 h-12 rounded-lg mr-2">
                                @endif
                                {{ App\Models\Recipe::find($date->recipe_id)->title }}
                            </a>
                            @endif
                        </div>
                    </div>


                </div>

            </div>
        @endforeach

        <div
            class="text-center grid grid-cols-1">
            {{ $dates->links() }}
        </div>

        <!-- Alert -->
        <div id="editAlert"
            class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50 hidden">
            <!-- Alert content -->
            <div class="bg-white rounded-lg shadow-lg p-10 w-96 h-auto">
                <!-- Alert title -->
                <h2 class="text-lg font-bold mb-4">Bearbeiten</h2>
                <!-- Update form -->
                <form action="{{ route('date.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    {{-- Date id --}}
                    <input type="hidden" name="dateId" id="dateId" />
                    <!-- Input text -->
                    <div class="mb-4">
                        <label for="dateText" class="block text-sm font-medium text-gray-700">Datum</label>
                        <input type="text" name="dateText" id="dateText"
                            class="mt-1 py-2 px-3 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-lg sm:text-sm border-gray-300 rounded-md">
                        @error('dateText')
                            <small class="text-sm text-red-500 font-semibold mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <!-- Select Praesentiert name -->
                    <div class="mb-4">
                        <input type="hidden" id="actualPraesentiertId" name="actualPraesentiertId" />
                        <label for="praesentiertSelect"
                            class="block text-sm font-medium text-gray-700">Präsentiert:</label>
                        <select id="praesentiertSelect" name="praesentiertSelect"
                            class="mt-1 cursor-pointer block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option id="optPraesentiert" selected></option>

                            @foreach ($personenPraesentieren as $personPraesentieren)
                                <option value="{{ $personPraesentieren->id }}">{{ $personPraesentieren->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <!-- Select Gekocht name -->
                    <div class="mb-4">
                        <input type="hidden" id="actualGekochtId" name="actualGekochtId" />
                        <label for="gekochtSelect" class="block text-sm font-medium text-gray-700">Gekocht:</label>
                        <select id="gekochtSelect" name="gekochtSelect"
                            class="mt-1 cursor-pointer block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option id="optGekocht" selected></option>

                            @foreach ($personenKochen as $personKochen)
                                <option value="{{ $personKochen->id }}">{{ $personKochen->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <!-- Select Rezept verwendet -->
                    <div class="mb-4">
                        <label for="rezeptSelect" class="block text-sm font-medium text-gray-700">Rezept:</label>
                        <select id="rezeptSelect" name="rezeptSelect"
                            class="mt-1 cursor-pointer block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Verwendetes Rezept auswählen</option>

                            @foreach (App\Models\Recipe::all() as $rezept)
                                <option value="{{ $rezept->id }}">{{ $rezept->title }}</option>
                            @endforeach
                        </select>
                        @error('rezeptSelect')
                            <small class="text-sm text-red-500 font-semibold mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Save
                        </button>
                        <button type="button" id="cancelButton"
                            class="ml-2 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                    </div>
                    @error('error')
                        <small class="text-sm text-red-500 font-semibold mt-1">{{ $message }}</small>
                    @enderror
                </form>
            </div>
        </div>

    </div>




    <script>
        // Obtain the alert
        const editAlert = document.getElementById('editAlert');
        // Obtain the cancel button
        const cancelButton = document.getElementById('cancelButton');

        // Show alert
        function showAlert(id, date, personPraesentierenId, personPraesentieren, personKochenId, personKochen, rezeptId) {

            document.getElementById('dateId').value = id;
            document.getElementById('dateText').value = date;

            document.getElementById('actualPraesentiertId').value = personPraesentierenId;
            document.getElementById('optPraesentiert').value = personPraesentierenId;
            document.getElementById('optPraesentiert').text = personPraesentieren;

            document.getElementById('actualGekochtId').value = personKochenId;
            document.getElementById('optGekocht').value = personKochenId;
            document.getElementById('optGekocht').text = personKochen;

            if (rezeptId) {
                document.querySelector('select[id="rezeptSelect"]').querySelector('option[value="' + rezeptId + '"]')
                    .selected = true;
            }

            editAlert.classList.remove('hidden');
        }

        // Hide alert
        function hideAlert() {
            editAlert.classList.add('hidden');
        }

        // Prevent click outside the alert
        editAlert.addEventListener('click', function(event) {
            if (event.target === editAlert) {
                event.stopPropagation();
            }
        });

        // Add EventListener to the cancel button
        cancelButton.addEventListener('click', hideAlert);

        // Add EventListener to the save button
        const saveButton = document.querySelector('[type="submit"]');
        saveButton.addEventListener('click', function(event) {
            // Prevent alert from hiding after clicking save
            event.preventDefault();
        });
    </script>

    <script>
        @if ($errors->has('dateText') || $errors->has('rezeptSelect') || $errors->has('error'))
            @php
                $actualPraesentiert = $dates->find(old('dateId'));
                $actualGekocht = $dates->find(old('dateId'));
            @endphp

            showAlert(
                '{{ old('dateId') }}',
                '{{ old('dateText') }}',
                '{{ old('actualPraesentiertId') }}',
                '{{ $actualPraesentiert ? $actualPraesentiert->namepraesentiert : '' }}',
                '{{ old('actualGekochtId') }}',
                '{{ $actualGekocht ? $actualGekocht->namegekocht : '' }}',
                '{{ old('rezeptSelect') }}'
            );
        @endif
    </script>

    <script>
        // Show or Hide the Save button next to Datum
        const forms = document.querySelectorAll('form[name="dateUpdate"]');

        forms.forEach(form => {
            const inputText = form.querySelector('input[type="text"]');
            const submitButton = form.querySelector('button[name="btnSub"]');

            inputText.addEventListener('input', function() {
                submitButton.classList.remove('hidden');
            });
        });
    </script>

</x-layout>
