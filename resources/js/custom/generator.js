// Funktion zum Verarbeiten der Daten im Textfeld

document.getElementById('fileInput').addEventListener('change', function(event) {
  var file = event.target.files[0];
  var reader = new FileReader();

  reader.onload = function(e) {
      var contents = e.target.result;
      document.getElementById('names').value = contents;
  };

  reader.readAsText(file);
  console.log('file read');
});

document.getElementById('generateBtn').addEventListener('click', allNames);


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
        winners.push(namesArray[randomIndex]);
        namesArray.splice(randomIndex, 1);
    }

    // Gewinner anzeigen
    var winnersList = document.createElement("ul");
    winners.forEach(function(winner) {
        var listItem = document.createElement("li");
        listItem.textContent = winner;
        winnersList.appendChild(listItem);
    });

    var resultDiv = document.querySelector(".result");
    resultDiv.innerHTML = "<h3>Winner(s):</h3>";
    resultDiv.appendChild(winnersList);

   
    var formData = new FormData();
    winners.forEach(function(winner) {
        formData.append('winners[]', winner);
    });

 
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_winners.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Erfolg
            console.log(xhr.responseText);
        } else {
            // Fehler
            console.error('Fehler beim Speichern der Gewinner: ' + xhr.statusText);
        }
    };
    xhr.send(formData);
}



// });