<x-layout>
    <div class="containerGewinner pt-16 lg:pt-2">
        <h1 class="gewinnerTitel text-center md:text-xl mt-5 mb-5" style="font-size: 2rem;">Gewinner</h1>
        <!-- Hier werden die Gewinner angezeigt -->
        @foreach ($winners as $winner)
        <div class="text-center grid grid-cols-1">
            <div class="flex justify-between items-center w-10/12 m-auto px-2">
                <h1 class="text-left ml-2 font-sans text-xl font-medium mt-4">
                    Datum:
                    <span class="w-28 rounded-full text-center w-32 py-1 bg-white px-3 py-2">
                        {{ \Carbon\Carbon::parse($winner->date)->format('d.m.Y') }}
                    </span>
                </h1>

                <div class="grid grid-cols-2">
                    <form action="{{ route('winner.destroy', $winner->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-left ml-2 mr-2 font-sans text-xl font-medium mt-4">
                            <img src="Delete.png" alt="" class="w-5 h-5 opacity-40 hover:opacity-50">
                        </button>
                    </form>
                </div>
            </div>

            <div class="winnerField font-sans text-lg font-normal relative grid grid-cols-4  rounded-xl m-2 rounded-2xl bg-gray-50 drop-shadow-xl hover:scale-105 ease-in-out duration-300">
                <!-- Hier werden die Gewinner aus der Datenbank abgerufen und angezeigt -->
                <div class="col-span-1 justify-self-center">
                    <strong>Name:</strong>
                </div>
                <div class="col-span-1 justify-self-start">
                    <?php
                    $names = explode(',', $winner->winner_name);
                    if (count($names) === 1) {
                        echo  trim($names[0], '"[]');
                    } else {
                        foreach ($names as $name) {
                            echo trim($name, '"[]') . '<br>';
                        }
                    }
                    ?>
                </div>
                <div class="col-span-1 justify-self-end">
                    <strong>Titel:</strong>
                </div>
                <div class="col-span-1 ">
                    {{ $winner->title }}
                </div>
            </div>
        </div>
        @endforeach
        <div class="text-center grid grid-cols-1 p-3">
            {{ $winners->links() }}
        </div>
    </div>

    <!-- Animation -->
    <div class="flex-container">
        <img class="cup" src="cup.png" alt="cup">
    </div>
</x-layout>