<?php
// Verbindung zur Datenbank herstellen (ersetze 'dbname', 'username', 'password' entsprechend)
$pdo = new PDO('mysql:host=db;dbname=laravel', 'root', 'password');

// Gewinner aus dem POST-Daten lesen
$winners = isset($_POST['winners']) ? $_POST['winners'] : [];

// Gewinner in die Datenbank einfügen
if (count($winners) == 1) {
    // Wenn es nur einen Gewinner gibt, diesen wie zuvor in einem separaten Eintrag speichern
    $stmt = $pdo->prepare("INSERT INTO winners (winner_name) VALUES (?)");
    $stmt->execute([$winners[0]]);
} elseif (count($winners) > 1) {
    // Wenn es mehr als einen Gewinner gibt, alle Gewinner zu einem Array zusammenführen
    $winnersArray = json_encode($winners);
    // Das Array in einer einzigen Zeile in der Datenbank speichern
    $stmt = $pdo->prepare("INSERT INTO winners (winner_name) VALUES (?)");
    $stmt->execute([$winnersArray]);
}

// Erfolgsnachricht senden
echo "Gewinner erfolgreich gespeichert!";
?>
