<x-layout>

    <div class="overflow-y-auto pb-10">
        <div class="text-center grid grid-cols-1 mx-[5vw] w-[90vw] lg:mx-[30vw] lg:w-[40vw]">

            <a href="/recipes/create" class="fixed top-4 right-4">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    New Recipe
                </button>
            </a>


            @foreach ($recipes as $recipe)
                <div
                    class="flex items-center relative grid grid-cols-6 m-2 py-4 rounded-xl bg-gray-50 drop-shadow-xl hover:scale-105 ease-in-out duration-300">

                    <p class="col-span-3">{{ $recipe->title }}</p>

                    <div class="col-span-1">
                        <div class="flex items-center">
                            @if (isset($employees->find($recipe->employee_id)->file_hash))
                                @if ($employees->find($recipe->employee_id)->file_hash == null)
                                    <img src="Profil.jpg" alt="" class="ml-8 w-9 h-9 rounded-full z-10">
                                @else
                                    <img src="{{ route('display.image', $employees->find($recipe->employee_id)->file_hash) }}"
                                        alt="" class="ml-8 w-9 h-9 rounded-full object-cover">
                                @endif
                            @else
                                <img src="Profil.jpg" alt="" class="ml-8 w-9 h-9 rounded-full z-10">
                            @endif
                        </div>
                    </div>

                    @if ($recipe->pdf_path)
                        <a href="{{ route('display.pdf', $recipe->pdf_path) }}" target="_blank">
                            <img src="{{ asset('pdf.png') }}" alt=""
                                class="col-span-1 ml-8 w-6 h-6 opacity-40 hover:opacity-50" />
                        </a>
                    @endif

                    <a href="/recipes/{{ $recipe->id }}">
                        <img src="eye.png" alt=""
                            class="col-span-1 ml-4 w-6 h-6 opacity-40 hover:opacity-50" />
                    </a>
                </div>
            @endforeach
        </div>

</x-layout>
