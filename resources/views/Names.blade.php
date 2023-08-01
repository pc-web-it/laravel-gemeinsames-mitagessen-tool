<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        clifford: '#da373d',
                    }
                }
            }
        }
    </script>
</head>

<body class="">
    

    
    <div
        class="bg-white p-4 z-20 lg:w-[120px] text-center  justify-normal left-0 right-0 lg:text-left fixed  grid grid-cols-4 lg:grid-cols-1">
        <div class="hover:scale-105 ease-in-out duration-300"><a href="/Namen"
                class=" px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Namen</a></div>
        <div class="lg:mt-5 hover:scale-105 ease-in-out duration-300"><a href="/"
                class=" px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Generator</a></div>
        <div class="lg:mt-5 hover:scale-105 ease-in-out duration-300 "><a href="/Verlauf"
                class=" px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl">Verlauf</a></div>
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



    <div class="text-center grid grid-cols-1 mx-[5vw] w-[90vw] lg:mx-[30vw] lg:w-[40vw] ">

        @foreach ($names as $name)
        <div
            class="relative grid grid-cols-5 m-2 py-3 rounded-2xl  bg-gray-50 drop-shadow-xl hover:scale-105 ease-in-out duration-300">


            <form action="{{ route('name.upload', $name->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid gird-cols-2">
                    @if($name->file_hash==null)
                    <img src="Profil.jpg" alt="" class="absolute ml-2 w-9 h-9 rounded-full z-10">
                    @else
                    <img src="{{ route('display.image', $name->file_hash) }}"
                        class="absolute ml-2 w-9 h-9 rounded-full object-cover">

                    @endif
                    
                    
                    
                    <label class="absolute ml-2 p-[17px] cursor-pointer rounded-full z-20">
                        <input type="file" name="file" class="hidden" onchange="form.submit()" />
                    </label>


                </div>
            </form>

            <form action="{{ route('name.update', $name->id) }}" method="POST" class="col-span-3 ">
                @csrf
                @method('PATCH')
                <div class="font-sans text-xl font-medium ">
                    <input type="text" value="{{$name->name}}" name="name" class="bg-gray-50 w-64" />
                    <div class="text-sm text-red-700">
                        @if($errors->any())
                            {{$errors->first($name->id)}}
                        @endif
                    </div>
                </div>
                <button class="absolute top-3 left-[66vw]  lg:left-[30vw]">
                    <img src="Save.png" alt="" class="w-8 h-8 opacity-40 hover:opacity-50 ">
                </button>

            </form>



            <form action="{{ route('name.destroy', $name->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="">
                    <button class="hover:scale-110 ease-in-out duration-300">
                        <img src="Delete.png" alt="" class="w-6 h-6 opacity-40 hover:opacity-50 ">
                    </button>
                </div>
            </form>



        </div>
        @endforeach


    </div>
    
</div>

</body>

</html>