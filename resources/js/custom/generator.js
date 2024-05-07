// Funktion zum Verarbeiten der Daten im Textfeld

// const { send } = require("vite");

document.getElementById('fileInput').addEventListener('change', function (event) {
    var file = event.target.files[0];
    var reader = new FileReader();

    reader.onload = function (e) {
        var contents = e.target.result;
        contents = contents.trim();
        document.getElementById('names').value = contents;
    };

    reader.readAsText(file);
    console.log('file read');
});

// Validates first if there are almost 'x' names (depend of the amount of winners) in the textarea
document.getElementById('generateBtn').addEventListener('click', function() {
    var namesTextarea = document.getElementById("names");
    var numberOfWinners = parseInt(document.getElementById("number").value);
    var names = namesTextarea.value.trim().split('\n').filter(function(name) {
        return name.trim() !== '';
    });

    // If names received is less than number of winners to generate...
    if (names.length < numberOfWinners+1) {
        // Throw a validate error
        document.getElementById('luckywheelErrors').textContent = `There must be at least ${numberOfWinners+1} names in the attached name list`;
        return;
    }

    // Also if all is correct, call to allNames function
    allNames();
});


// document.addEventListener("DOMContentLoaded", function() {
function allNames() {
    // String aus der Textarea zu einem Array
    var namesTextarea = document.getElementById("names");
    var namesArray = namesTextarea.value.split('\n');

    // Anzahl der Gewinner
    var numberOfWinners = parseInt(document.getElementById("number").value);

    // Zufällige Gewinner auswählen
    var winners = [];
    while (winners.length < numberOfWinners && namesArray.length > 0) {
        var randomIndex = Math.floor(Math.random() * namesArray.length);
        // Clean the name to remove any extra whitespace
        var winner = namesArray[randomIndex].trim();
        if (winner !== "") {
            winners.push(winner);
        }
        namesArray.splice(randomIndex, 1);
    }


    // Gewinner anzeigen
    var winnersList = document.createElement("ul");
    winners.forEach(function (winner) {
        var listItem = document.createElement("li");
        listItem.textContent = winner;
        winnersList.appendChild(listItem);
    });

    var resultDiv = document.querySelector(".result");
    resultDiv.innerHTML = "<h3>Winner(s):</h3>";
    resultDiv.appendChild(winnersList);


    var formData = new FormData();
    winners.forEach(function (winner) {
        formData.append('winners[]', winner);
    });

    sendNames(winners);

    // var xhr = new XMLHttpRequest();
    // xhr.open('POST', 'save_winners.php', true);
    // xhr.onload = function() {
    //     if (xhr.status === 200) {
    //         // Erfolg
    //         console.log(xhr.responseText);
    //     } else {
    //         // Fehler
    //         console.error('Fehler beim Speichern der Gewinner: ' + xhr.statusText);
    //     }
    // };
    // xhr.send(formData);
}

function sendNames(winners) {
    document.getElementById('winner_name').value = JSON.stringify(winners);
}

// });
