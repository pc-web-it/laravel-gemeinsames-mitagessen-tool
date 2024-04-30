<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    @vite('resources/css/app.css')
     <title>Random Name Generator</title>

    <!-- <link rel="stylesheet" href="{{ asset('/generator.css') }}"> -->
    <!-- <script>
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
    <link rel="stylesheet" type="text/css" href="{{asset('style.css?v=').time()}}" /> -->
</head>

<body class="overflow-y-auto">
    <!-- Navbar -->
    <div class="z-10 p-5 bg-white fixed top-0 lg:w-[120px] text-center justify-normal left-0 right-0 lg:text-left  grid grid-cols-4 lg:grid-cols-1">
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

    <div class="text-center mt-10">
    <form id="numberForm">
        <label for="numberOfWinners">Number of winners:</label>
        <input id="number" name="number" type="number" value="1" class="border-double border-4 border-indigo-600"/>
        <hr>
    </form>
    <form id="nameForm">
        <label for="names">Name generator:</label><br>
        <textarea class="border-double border-4 border-indigo-600" name="names" id="names" cols="30" rows="10"></textarea><br>
        <input type="file" id="fileInput" accept=".csv"><br>
        <!-- <button type="button" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg" onclick="allNames()">Generate</button> -->
        <button id="generateBtn" type="button" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg">Generate</button>
        
    </form>
    <form action="save_winners.php" method="POST">
    <p class="result"></p>
    <input type="submit" value="Save" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg">
</form>

</div>

<!-- <script src="{{ asset('/generator.js') }}"></script> -->
@vite('resources/js/app.js')
</body>

</html>
