<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Random Name Generator</title>   
    <link rel="stylesheet" type="text/css" href="{{ asset('style.css?v=') . time() }}" /> 
</head>

<body class="overflow-y-auto">
    <!-- Navbar -->
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
    
    <!-- Hauptinhalt -->

<div class="generatorAndBackground">

    <div class="container">
        <div class="inner-container">
            <div class="left-section">
             <h1 id="randomTitel">Random Name Generator</h1>
             <form id="numberForm">
                <label for="numberOfWinners" id="numberLabel">Number of winners:</label>
                <input id="number" name="number" type="number" value="1" class="border-double border-4 border-indigo-600"/>
              </form>
                <form id="nameForm">
                <label for="names" id="namesLabel">Write your names here or upload your text file:</label><br>
                <div class="upload-container">
                    <textarea class="border-double border-4 border-indigo-600" name="names" id="names"  rows="10"></textarea>
                    <label for="fileInput" class="custom-file-upload">
                         <img src="csv_upload.png" alt="CSV Upload" class="upload-icon " style="width: 40px; height: 40px; vertical-align: middle;">
                    </label>
                    <input type="file" id="fileInput" accept=".csv">
                </div>
                <button id="generateBtn" type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Generate</button>
            </form>
        </div>
        <div class="right-section">
            <h2 id="randomTitel">Winners</h2>
            <div id="winners"></div>
            <form id="winnersArea" action="{{ route('winner.store') }}" method="POST">
                <div class="winnersContainer ">  
                    @csrf
                @method('PUT')
              
                 <p class="result"></p>
                </div>
                <input type="hidden" name="winner_name" id="winner_name" />
                <input type="submit" value="Save" id="saveButton" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg">
            </form>
            @error('winner_name')
                <small class="text-sm text-red-500 font-semibold mt-1">{{ $message }}</small>
            @enderror
            <small id="luckywheelErrors" class="text-sm text-red-500 font-semibold mt-1"></small>
            
        </div>


        
    </div>


   


</div>

 <!-- Animation -->

    <div>
        <img class="giftBox" src="giftBox.png" alt="giftBox">
    </div>

     <div class="balloonsPlace">
             <img class="balloons" src="balloons.png" alt="balloons">
     </div>
</div>

        
    @vite('resources/js/app.js')
</body>

</html>
