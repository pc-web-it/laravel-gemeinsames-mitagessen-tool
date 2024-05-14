<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Gewinner</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('style.css?v=') . time() }}" />
</head>

<body class="overflow-y-auto">
    <!-- Navbar -->
    <div
        class="z-10 p-5 fixed top-0 lg:w-[160px] text-center justify-normal left-0 right-0 lg:text-left grid grid-cols-4 lg:grid-cols-1 rounded-lg">
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

    <!-- Hauptinhalt -->
    <div class="containerGewinner pt-16 lg:pt-2">
        <h1 class="gewinnerTitel text-center md:text-xl mt-5 mb-5" style="font-size: 2rem;">Gewinner</h1>
        <!-- Hier werden die Gewinner angezeigt -->
        @foreach ($winners as $winner)
            <div
                class="text-center grid grid-cols-1 ">
                <!-- Hier wird die Liste der Gewinner angezeigt -->
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
        <div
            class="text-center grid grid-cols-1 p-3" >
            {{ $winners->links() }}
        </div>
    </div>


<!-- Animation -->

<div>
        <img class="cup" src="cup.png" alt="cup">
</div>



    @vite('resources/js/app.js')
</body>

</html>
