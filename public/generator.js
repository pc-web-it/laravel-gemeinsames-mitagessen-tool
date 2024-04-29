// Funktion zum Verarbeiten der Daten im Textfeld


// document.addEventListener("DOMContentLoaded", function() {
  function allNames() {
      //String aus der Textarea zu einem Array 
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
  }
// });