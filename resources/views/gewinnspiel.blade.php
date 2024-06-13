<x-layout>
    <!-- Hauptinhalt -->

    <div class="generatorAndBackground">

        <div class="container">
            <div class="inner-container">
                <div>
                    <h1 id="randomTitel">Random Name Generator</h1>

                    <form id="numberForm">
                        <label for="numberOfWinners" id="numberLabel">Anzahl der Gewinner:</label>
                        <input id="number" name="number" type="number" value="1" class="border-double border-4 border-indigo-600" />
                    </form>
                    <form id="nameForm">
                        <label for="names" id="namesLabel">Schreiben Sie Namen hier oder laden Sie eine Textdatei hoch:</label><br>
                        <div class="upload-container">
                            <textarea class="border-double border-4 border-indigo-600" name="names" id="names" rows="10"></textarea>
                            <label for="fileInput" class="custom-file-upload">
                                <img src="csv_upload.png" alt="CSV Upload" class="upload-icon " style="width: 40px; height: 40px; vertical-align: middle;">
                            </label>
                            <input type="file" id="fileInput" accept=".csv">
                        </div>
                        <button id="generateBtn" type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-full">Generieren</button>
                    </form>
                </div>
                <div>
                    <h2 id="randomTitel">Gewinner</h2>
                    <div id="winners"></div>
                    <form id="winnersArea" action="{{ route('winner.store') }}" method="POST">

                <div class="mb-8">
                        <label for="title" class="text-xl">Titel:</label>
                        <input type="text" id="title" name="title" class="border-double border-4 border-indigo-600" required />
                </div>
                    

                        <div class="winnersContainer">
                            @csrf
                            @method('PUT')

                            <p class="result"></p>
                        </div>
                        <input type="hidden" name="winner_name" id="winner_name" />
                        
                        <input type="submit" value="Speichern" id="saveButton" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-full cursor-pointer" />
                    </form>
                    @error('winner_name')
                    <small class="text-sm text-red-500 font-semibold mt-1">{{ $message }}</small>
                    @enderror
                    <small id="luckywheelErrors" class="text-sm text-red-500 font-semibold mt-1"></small>

                </div>



            </div>





        </div>

        <!-- Animation -->

        <img class="giftBox" src="giftBox.png" alt="giftBox">

        <img class="balloons" src="balloons.png" alt="balloons">
    </div>


    @vite('resources/js/app.js')

</x-layout>