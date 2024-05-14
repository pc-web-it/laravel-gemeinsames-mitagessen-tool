<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
     @vite('resources/css/app.css') 
     <title>Document</title>
   
    <style>
        .flex-container {
            display: flex;
            flex-direction: column; 
        }

        .profile-icon-container {
            margin-left: 5px; 
        }
        
    </style>
</head>

<body>
    
    <div
        class="p-4 z-20 lg:w-[160px] text-center  justify-normal left-0 right-0 lg:text-left fixed  grid grid-cols-4 lg:grid-cols-1 rounded-lg">
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
            class=" px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl"> Logout</a></div>

    </div>

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
                @if($errors->any())
                    {{$errors->first('eingabe')}}
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
            <div class="relative grid grid-cols-6 m-2 py-3 rounded-2xl bg-gray-50 drop-shadow-xl hover:scale-105 ease-in-out duration-300">

                <form action="{{ route('name.upload', $name->id) }}" method="POST" enctype="multipart/form-data" class="col-span-2 flex items-center space-x-6">
                    @csrf
                    @method('PUT')
                    <div class="flex-container items-center space-x-2 relative">
                        <div class="profile-icon-container relative">
                            @if($name->file_hash==null)
                                <img src="Profil.jpg" alt="" class="w-7 h-7 rounded-full">
                            @else
                                <img src="{{ route('display.image', $name->file_hash) }}" alt="" class="w-7 h-7 rounded-full object-cover">
                            @endif
                        </div>
                        <label class="absolute p-[14px] cursor-pointer">
                            <input type="file" name="file" class="hidden" onchange="form.submit()" />
                        </label>
                        <div class="flex ">
                            @if($name->praesentiert == 1)
                                <img src="pr.png" alt="Praesentiert Icon" class="w-5 h-5 opacity-40">
                            @endif

                            @if($name->gekocht == 1)
                                <img src="ge.png" alt="Gekocht Icon" class="w-5 h-5 opacity-40">
                            @endif
                        </div>
                    </div>
                </form>


                <form action="{{ route('name.update', $name->id) }}" method="POST" class="col-span-3 flex items-center space-x-2">
                    @csrf
                    @method('PATCH')
                    <input type="text" value="{{ $name->name }}" name="name" class="bg-gray-50 w-64" />
                    <div class="text-sm text-red-700">
                        @if($errors->any())
                            {{ $errors->first($name->id) }}
                        @endif
                    </div>
                    <button type="submit" class="ml-auto">
                        <img src="Save.png" alt="" class="w-6 h-6 opacity-40 hover:opacity-50">
                    </button>
                </form>

                <form action="{{ route('name.destroy', $name->id) }}" method="POST"class="col-span-1 flex items-center space-x-2">
                    @csrf
                    @method('DELETE')
                    <button>
                        <img src="Delete.png" alt="" class="w-6 h-6 opacity-40 hover:opacity-50">
                    </button>
                </form>
            </div>
        @endforeach

    </div>


</body>

</html>