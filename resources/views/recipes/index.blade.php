<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gemeinsames Mittagessen Tool</title>

    @vite('resources/css/app.css')
    <!-- <style>
        .flex-container {
            display: flex;
            flex-direction: column;
        }

        .profile-icon-container {
            margin-left: 5px;
        }
    </style> -->
      <link rel="stylesheet" type="text/css" href="{{ asset('style.css?v=') . time() }}" /> 
</head>

<body class="">

<div
        class="z-10 p-5 fixed top-0 lg:w-[180px] text-center justify-normal left-0 right-0 lg:text-left grid grid-cols-4 lg:grid-cols-1 rounded-lg">
        <div class="text-center hover:scale-105 ease-in-out duration-300"><a href="/Namen"
                class="navBtn block px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Mitarbeiter</a></div>
        <div class="text-center  lg:mt-5 hover:scale-105 ease-in-out duration-300"><a href="/"
                class="navBtn block px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Generator</a></div>
        <div class="text-center  lg:mt-5 hover:scale-105 ease-in-out duration-300 "><a href="/Verlauf"
                class="navBtn block px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Verlauf</a></div>
        <div class="text-center  lg:mt-5 hover:scale-105 ease-in-out duration-300 "><a href="/gewinnspiel"
                class="navBtn block px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Gewinnspiel</a></div>
        <div class="text-center  lg:mt-5 hover:scale-105 ease-in-out duration-300 "><a href="/gewinner"
                class="navBtn block px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Gewinner</a></div>
        <div class="text-center  lg:mt-5 hover:scale-105 ease-in-out duration-300 "><a href="/recipes"
                class="navBtn block px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Rezepte</a></div>
        <div class="text-center  lg:mt-5 hover:scale-105 ease-in-out duration-300 "><a href="/logout"
                class="navBtn block px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Logout</a></div>
    </div>


    <div class="overflow-y-auto pb-10">
        <div class="containerRecipes text-center grid grid-cols-1">

        
            <h1 class="recipesTitel text-center md:text-xl" style="font-size: 2rem;">Rezepte</h1>
           
            <!-- bg-sky-400 hover:bg-cyan-600 -->

            <a href="/recipes/create" class="flex flex-row-reverse">
                <button class="newRecipeBtn text-white font-bold py-2 px-4 m-5 rounded drop-shadow-xl hover:scale-105 ease-in-out duration-300">
                    New Recipe
                </button>
            </a>
            @foreach ($recipes as $recipe)
            
                <div
                    class="flex items-center relative grid grid-cols-6 m-2 py-4  rounded-xl bg-gray-50 drop-shadow-xl hover:scale-105 ease-in-out duration-300">

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
                            <img src="{{ asset('pdf.png') }}" alt="" class="col-span-1 ml-8 w-6 h-6 opacity-40 hover:opacity-50"/>
                        </a>
                    @endif

                    <a href="/recipes/{{ $recipe->id }}">
                        <img src="eye.png" alt="" class="col-span-1 ml-4 w-6 h-6 opacity-40 hover:opacity-50"/>
                    </a>
                </div>
            @endforeach
        </div>


        

        @vite('resources/js/app.js')

</body>

</html>
