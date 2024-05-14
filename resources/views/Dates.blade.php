<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="{{asset('style.css?v=').time()}}" />
</head>

<body class="overflow-y-auto">
    <div
        class="z-10 p-5 fixed top-0 lg:w-[160px] text-center justify-normal left-0 right-0 lg:text-left  grid grid-cols-4 lg:grid-cols-1 rounded-lg">
        <div class="hover:scale-105 ease-in-out duration-300"><a href="/Namen"
                class=" px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Mitarbeiter</a></div>
        <div class="lg:mt-5 hover:scale-105 ease-in-out duration-300"><a href="/"
                class=" px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Generator</a></div>
        <div class="lg:mt-5 hover:scale-105 ease-in-out duration-300 "><a href="/Verlauf"
                class=" px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Verlauf</a></div>
        <div class="lg:mt-5 hover:scale-105 ease-in-out duration-300 "><a href="/gewinnspiel"
                class=" px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Gewinnspiel</a></div>
        <div class="lg:mt-5 hover:scale-105 ease-in-out duration-300 "><a href="/gewinner"
                class=" px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Gewinner</a></div>
        <div class="lg:mt-5 hover:scale-105 ease-in-out duration-300 "><a href="/logout"
            class=" px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Logout</a></div>
    </div>

    
    <div class="containerVerlauf pt-16 lg:pt-2">
    <h1 class="verlaufTitel text-center md:text-xl mt-5 mb-5" style="font-size: 2rem;">Verlauf</h1>

        @foreach ($dates as $date)


        <!-- mx-[5vw] w-[90vw] lg:mx-[15vw] lg:w-[70vw] 2xl:mx-[20vw] 2xl:w-[60vw] -->

        <div class="text-center grid grid-cols-1 px-20">
            <div class="flex justify-between items-center">
                <form action="/DateUpdate/{{$date->id}}" method="GET">
                    @csrf
                    @method('PUT')
                    <h1 class="text-left ml-2 font-sans text-xl font-medium mt-4">
                        Datum:
                        <input type="text" value="{{$date->date}}" name="date" class=" w-28 rounded-full" />
                        <button class="mr-2">
                            <img src="Save.png" alt="" class="w-5 h-5 opacity-40 hover:opacity-50">
                        </button>
                        <div class="text-sm text-red-700">
                            @if($errors->any())
                                {{$errors->first($date->id)}}
                            @endif
                        </div>
                    </h1>
                </form>
                <form action="{{ route('date.destroy', $date->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-left ml-2 mr-2 font-sans text-xl font-medium mt-4" class="ml-2">
                        <img src="Delete.png" alt="" class="w-5 h-5 opacity-40 hover:opacity-50">
                    </button>
                </form>
            </div>
            <div class="font-sans text-lg font-normal relative grid grid-cols-5 2xl:grid-cols-10 m-3 p-3 rounded-2xl bg-gray-50 drop-shadow-xl hover:scale-105 ease-in-out duration-300">

                <h2 class="col-span-2">Praesentiert:</h2>

                <div class="col-span-3">
                    <button id="btnDropdown" class="flex items-center">
                        @if(isset($date->praesentiert->file_hash))
                            @if($date->praesentiert->file_hash==null)
                                <img src="Profil.jpg" alt="" class="ml-8 w-9 h-9 rounded-full z-10">
                            @else
                                <img src="{{ route('display.image', $date->praesentiert->file_hash) }}" alt=""
                                    class="ml-8 w-9 h-9 rounded-full object-cover">
                            @endif
                        @else
                            <img src="Profil.jpg" alt="" class="ml-8 w-9 h-9 rounded-full z-10">
                        @endif
                        <div class="ml-10">
                            {{$date->namepraesentiert}}
                        </div>
                    </button>

                    <div class="z-20" id="content">
                        @if($personenPraesentieren->first()==null)
                            <div class="relative text-md mt-2 rounded-2xl bg-gray-100 drop-shadow-xl p-3">Niemand zur Auswahl</div>
                        @endif
                        @foreach($personenPraesentieren as $personPraesentieren)
                            <div class="relative text-md mt-2 rounded-2xl bg-gray-100 drop-shadow-xl p-4">
                                <a href="/VerlaufPraesentieren/{{$personPraesentieren->id}}/{{$date->namepraesentiertid}}/{{$date->id}}"
                                    class="grid gird-cols-2">
                                    @if($personPraesentieren->file_hash==null)
                                        <img src="Profil.jpg" alt="" class="absolute ml-2 w-9 h-9 rounded-full z-10">
                                    @else
                                        <img src="{{ route('display.image', $personPraesentieren->file_hash) }}" alt=""
                                            class="absolute ml-2 w-9 h-9 rounded-full object-cover">
                                    @endif
                                    <div>
                                        {{$personPraesentieren->name}}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>


                <h2 class="col-span-2 mt-5 2xl:mt-0">Gekocht:</h2>

                <div class="col-span-3 mt-5 2xl:mt-0">
                    <button id="btnDropdown" class="flex items-center">
                        @if(isset($date->gekocht->file_hash))
                            @if($date->gekocht->file_hash==null)
                                <img src="Profil.jpg" alt="" class="ml-8 w-9 h-9 rounded-full z-10">
                            @else
                                <img src="{{ route('display.image', $date->gekocht->file_hash) }}" alt=""
                                    class="ml-8 w-9 h-9 rounded-full object-cover">
                            @endif
                        @else
                            <img src="Profil.jpg" alt="" class="ml-8 w-9 h-9 rounded-full z-10">
                        @endif
                        <div class="ml-10">
                            {{$date->namegekocht}}
                        </div>
                    </button>

                    <div class="z-20" id="content">
                        @if($personenKochen->first()==null)
                            <div class="relative text-md mt-2 rounded-2xl bg-gray-100 drop-shadow-xl p-3">Niemand zur Auswahl</div>
                        @endif
                        @foreach($personenKochen as $personKochen)
                            <div class="relative text-md mt-2 rounded-2xl bg-gray-100 drop-shadow-xl p-3">
                                <a href="/VerlaufKochen/{{$personKochen->id}}/{{$date->namegekochtid}}/{{$date->id}}"
                                    class="grid gird-cols-2">
                                    @if($personKochen->file_hash==null)
                                        <img src="Profil.jpg" alt="" class="absolute ml-2 w-9 h-9 rounded-full z-10">
                                    @else
                                        <img src="{{ route('display.image', $personKochen->file_hash) }}" alt=""
                                            class="absolute ml-2 w-9 h-9 rounded-full object-cover">
                                    @endif
                                    <div>
                                        {{$personKochen->name}}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        @endforeach
    </div>
  
</body>

</html>
