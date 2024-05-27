<x-layout>

    <!-- Hauptinhalt -->
    <div class="containerGewinner pt-16 lg:pt-2">
        <h1 class="gewinnerTitel text-center md:text-xl mt-5 mb-5" style="font-size: 2rem;">Gewinner</h1>
        <!-- Hier werden die Gewinner angezeigt -->
        @foreach ($winners as $winner)

        
            <div class="text-center grid grid-cols-1 ">
                <!-- Hier wird die Liste der Gewinner angezeigt -->

            
                
                    <div class="m-auto w-3/6 col-span-2 mb-2 flex items-center justify-end">
                        <!-- Delete button -->
                        <form action="{{ route('winner.destroy', $winner->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-left ml-2 mr-2 font-sans text-xl font-medium mt-4">
                                <img src="Delete.png" alt="" class="w-5 h-5 opacity-40 hover:opacity-50">
                            </button>
                        </form>
                    </div>

         

                <div
                    class="winnerField font-sans text-lg font-normal relative grid grid-cols-5 2xl:grid-cols-10 rounded-lg m-2rounded-2xl bg-gray-50 drop-shadow-xl hover:scale-105 ease-in-out duration-300">

                    <!-- Hier werden die Gewinner aus der Datenbank abgerufen und angezeigt -->

                    

                    <div class="col-span-2 mb-4">
                        <div><strong>Datum:</strong> {{ \Carbon\Carbon::parse($winner->date)->format('d.m.Y') }} </div>
                    </div>
                    <div class="col-span-6 mb-4">
                        <div><strong>Name:</strong>
                            <?php
                            $names = explode(',', $winner->winner_name);
                            if (count($names) === 1) {
                                echo '<br>' . trim($names[0], '"[]');
                            } else {
                                foreach ($names as $name) {
                                    echo '<br>' . trim($name, '"[]');
                                }
                            }
                            ?>

                        </div>
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


    @vite('resources/js/app.js')

</x-layout>
