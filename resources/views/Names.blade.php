<x-layout>

    <div class="overflow-y-auto pb-10">
        <form action="/Namen" method="POST" class="mt-2 lg:mt-0">
            @csrf
            <div class="relative text-center lg:mx-[30vw] lg:w-[40vw] hover:scale-105 ease-in-out duration-300 mb-2">
                <input type="text" name="name"
                    class=" mt-14 mb-2 w-[90vw]  lg:w-[40vw] lg:mt-5 text-xl font-medium text-center bg-gray-50 placeholder:italic placeholder:text-slate-400  placeholder:text-xl rounded-3xl py-6 drop-shadow-xl	  focus:outline-none focus:border-white focus:ring-white focus:ring-1"
                    placeholder="Name">
                <button class="absolute left-[85vw] top-20 lg:left-[35vw] lg:top-10 z-10">
                    <img src="Save.png" alt="" class="w-8 h-8  opacity-40 hover:opacity-50">
                </button>
                <div class="text-sm text-red-700 mb-2">
                    @if ($errors->any())
                        {{ $errors->first('eingabe') }}
                    @endif
                </div>
                <!--
                @if ($errors->any())
<div class="text-sm text-red-600 absolute top-[70px] z-10 right-0 left-0">
                        <ul>
                            @foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
                        </ul>
                    </div>
@endif-->
            </div>

        </form>

        <div class="text-center grid grid-cols-1 mx-[5vw] w-[90vw] lg:mx-[30vw] lg:w-[40vw]">

            @foreach ($names as $name)
                <div
                    class="relative grid grid-cols-6 m-2 py-3 rounded-2xl bg-gray-50 drop-shadow-xl hover:scale-105 ease-in-out duration-300">

                    <form id="form-{{ $name->id }}" action="{{ route('name.upload', $name->id) }}" method="POST"
                        enctype="multipart/form-data" class="col-span-2 flex items-center space-x-6">
                        @csrf
                        @method('PUT')
                        <div class="flex-container items-center space-x-2 relative">
                            <label for="profile-{{ $name->id }}" class="cursor-pointer">
                                <div class="profile-icon-container relative">
                                    @if ($name->file_hash == null)
                                        <img src="Profil.jpg" alt="" class="w-7 h-7 rounded-full">
                                    @else
                                        <img src="{{ route('display.image', $name->file_hash) }}" alt=""
                                            class="w-7 h-7 rounded-full object-cover">
                                    @endif
                                </div>
                            </label>
                            <input id="profile-{{ $name->id }}" type="file" name="file" class="hidden"
                                onchange="document.getElementById('form-{{ $name->id }}').submit()" />
                            <div class="flex">
                                @if ($name->praesentiert == 1)
                                    <img src="pr.png" alt="Praesentiert Icon" class="w-5 h-5 opacity-40">
                                @endif

                                @if ($name->gekocht == 1)
                                    <img src="ge.png" alt="Gekocht Icon" class="w-5 h-5 opacity-40">
                                @endif
                            </div>
                        </div>
                    </form>


                    <form action="{{ route('name.update', $name->id) }}" method="POST" name="updateForm"
                        class="col-span-3 flex items-center space-x-2">
                        @csrf
                        @method('PATCH')
                        <input id="inputTextName" type="text" value="{{ $name->name }}" name="name"
                            class="bg-gray-50 w-32" />
                        <div class="text-sm text-red-700">
                            @if ($errors->any())
                                {{ $errors->first($name->id) }}
                            @endif
                        </div>

                        {{-- Icon like checkbox to declarate if the employee is available or not --}}
                        <label for="is_available{{ $name->id }}">
                            <img id="zzzImg" src="zzz.png" alt="sleepIcon"
                                class=" {{ $name->is_available ? 'hidden' : '' }} w-6 h-6 opacity-40" />
                        </label>

                        <input type="checkbox" id="is_available{{ $name->id }}" name="is_available" class="hidden"
                            {{ $name->is_available ? '' : 'checked' }} />

                        <button id="submitSaveButton" type="submit" class="hidden ml-auto">
                            <img src="Save.png" alt="" class="w-6 h-6 ml-2 opacity-40 hover:opacity-50">
                        </button>
                    </form>

                    <form id="delete-form-{{ $name->id }}" action="{{ route('name.destroy', $name->id) }}"
                        method="POST"class="col-span-1 flex items-center space-x-2">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="showConfirmModal('{{ $name->name }}', 'names', 'delete-form-{{ $name->id }}')">
                            <img src="Delete.png" alt="" class="w-6 h-6 opacity-40 hover:opacity-50">
                        </button>
                    </form>
                </div>
            @endforeach

            <div>
                {{ $names->links() }}
            </div>
        </div>

    </div>

    <x-confirm-alert />

    <script>
        // Save and ZZZ button appear or disappear logic in update form
        const forms = document.querySelectorAll('form[name="updateForm"]');

        forms.forEach(form => {
            const inputText = form.querySelector('input[type="text"]');
            const submitButton = form.querySelector('button[type="submit"]');
            const zzzImg = form.querySelector('img[id^="zzzImg"]');
            const zzzCheck = form.querySelector('input[type="checkbox"]');

            inputText.addEventListener('focus', function() {
                submitButton.classList.remove('hidden');
                zzzImg.classList.remove('hidden');
                zzzImg.classList.add('cursor-pointer', 'hover:opacity-40');
                zzzImg.src = zzzCheck.checked ? "zzz-green.png" :
                    "zzz.png"; // Change img color depends if the user is available or not

                zzzImg.addEventListener('click', function() {
                    if (zzzImg.src.includes('zzz.png')) {
                        zzzImg.src = "zzz-green.png";
                    } else if (zzzImg.src.includes('zzz-green.png')) {
                        zzzImg.src = "zzz.png";
                    }
                });
            });


        });
    </script>

</x-layout>
