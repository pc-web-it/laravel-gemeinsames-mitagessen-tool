<x-layout>

    <div class="overflow-y-auto pb-10">
        <div class="containerRecipes text-center grid grid-cols-1">

        
            <h1 class="recipesTitel text-center md:text-xl" style="font-size: 2rem;">Rezepte</h1>
           
            <!-- bg-sky-400 hover:bg-cyan-600 -->

            <a href="/recipes/create" class="flex flex-row-reverse">
                <button class="newRecipeBtn rounded-full text-white font-bold py-2 px-4 m-5 rounded drop-shadow-xl hover:scale-105 ease-in-out duration-300">
                    Neues Rezept
                </button>
            </a>
            @foreach ($recipes as $recipe)
            
            <div class="flex flex-wrap items-center relative grid grid-cols-6 m-2 py-4 rounded-2xl bg-gray-50 drop-shadow-xl hover:scale-105 ease-in-out duration-300">

<p class="col-span-3">{{ $recipe->title }}</p>

<div class="col-span-2">
    <div class="flex items-center">
        @if (isset($employees->find($recipe->employee_id)->file_hash) && $employees->find($recipe->employee_id)->file_hash != null)
            <img src="{{ route('display.image', $employees->find($recipe->employee_id)->file_hash) }}" alt="" class="ml-8 w-9 h-9 rounded-full object-cover">
        @else
            <img src="Profil.jpg" alt="" class="ml-8 w-9 h-9 rounded-full z-10">
        @endif
        <p class="text-gray-700 ml-3">{{ $employees->find($recipe->employee_id)->name }}</p>
    </div>
</div>

<div class="col-span-1 flex justify-start space-x-5">

<a href="/recipes/{{ $recipe->id }}">
        <img src="eye.png" alt="" class="w-6 h-6 opacity-40 hover:opacity-50" />
    </a>

    @if ($recipe->pdf_path)
        <a href="{{ route('display.pdf', $recipe->pdf_path) }}" target="_blank" class="mr-4">
            <img src="{{ asset('pdf.png') }}" alt="" class="w-6 h-6 opacity-40 hover:opacity-50" />
        </a>
    @endif
  
</div>

</div>

            @endforeach
        </div>


        

        @vite('resources/js/app.js')

</x-layout>
