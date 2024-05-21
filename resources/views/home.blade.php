<x-layout>


    <form action="/random" method="GET" class="overflow-hidden">

            <button class=" text-[5vw]  font-sans font-medium py-4 px-12 static text-center mt-16 md:mt-10 md:w-[50vw] md:ml-[25vw]  bg-neutral-50 w-[80vw] ml-[10vw] lg:w-[35vw] lg:ml-[32.5vw] p-5 rounded-full hover:scale-105 ease-in-out duration-300">
                Generate
            </button>
            <h1 class="text-center ml-2 font-sans text-xl font-medium mt-4 p-2">
            Datum:
            <input type="text" value="{{$datum}}" name="date" class="text-center w-32 p-1 rounded-full" />
            <div class="text-sm text-red-700 mb-2">
                @if ($errors->any())
                    {{ $errors->first('date') }}
                @endif
            </div>
        </h1>
    </form>

    <form action="{{ route('regenerate.data') }}" method="GET" class="text-center mt-4">
        @if (session('showRegenerateButton', false))
            <button type="submit"
                class="text-[3vw] md:text-[2vw] font-sans font-medium py-3 px-8 md:w-[40vw] lg:w-[20vw] p-4 rounded-full bg-neutral-50 hover:scale-105 ease-in-out duration-300">
                Regenerate
            </button>
            <input type="hidden" name="date" value="{{ $datum }}">
            <div class="text-sm text-red-700 mb-2">
                @if ($errors->any())
                    {{ $errors->first('date') }}
                @endif
            </div>
        @endif
    </form>

    @if ($errors->has('no_employees'))
        <div class="text-center  ml-2 font-sans text-xl font-medium mt-4">
            <small class="text-sm text-red-500 font-semibold mt-1">{{ $errors->first('no_employees') }}</small>
        </div>
    @endif

    <div class="grid grid-cols-1 text-2xl md:grid-cols-2  text-center mt-16">
        <div>
            <div class="font-sans text-2xl lg:text-3xl font-medium">
                Präsentieren:
            </div>
            <div class="grid grid-cols-1 font-sans text-2xl lg:text-3xl font-medium mt-5 " id="personPraesentieren">

                @if ($random1 != null)


                    @if ($random1->file_hash == null)
                        <div class="flex items-center justify-center">
                            <img src="Profil.jpg" alt="" class=" w-28 h-28 rounded-full z-10 object-cover">
                        </div>
                    @else
                        <div class="flex items-center justify-center">
                            <img src="{{ route('display.image', $random1->file_hash) }}" alt=""
                                class="w-28 h-28 rounded-full object-cover">
                        </div>
                    @endif
                    <div>
                        {{ $random1->name }}
                    </div>
                @else
                    <div class="h-[144px] md:hidden"></div>
                @endif


            </div>
        </div>
        <div class="mt-5 md:mt-0">
            <div class="font-sans text-2xl lg:text-3xl font-medium">
                Kochen:
            </div>
            <div class="grid grid-cols-1 font-sans text-2xl lg:text-3xl font-medium mt-5  " id="personKochen">

                @if ($random2 != null)


                    @if ($random2->file_hash == null)
                        <div class="flex items-center justify-center">
                            <img src="Profil.jpg" alt="" class=" w-28 h-28 rounded-full z-10 object-cover">
                        </div>
                    @else
                        <div class="flex items-center justify-center">
                            <img src="{{ route('display.image', $random2->file_hash) }}" alt=""
                                class="w-28 h-28 rounded-full object-cover">
                        </div>
                    @endif
                    <div>
                        {{ $random2->name }}
                    </div>

                @endif


            </div>
        </div>
    </div>
    @if ($random1 !== null)
        <div class="w-[100vw] relative h-96 text-center  -z-20">
            <div class="gird grid-cols-3 w-[70vw] h-[100vh] absolute bottom-0 -z-20">
                <div class="firework"></div>
                <div class="firework"></div>
                <div class="firework"></div>
            </div>
            <div class="gird grid-cols-3 w-[70vw] h-[100vh] absolute left-[35vw] bottom-0 -z-20">
                <div class="firework"></div>
                <div class="firework"></div>
                <div class="firework"></div>
            </div>
        </div>
    @endif

    </div>

</x-layout>
