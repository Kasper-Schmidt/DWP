<?php
require_once("upload.php");

// Tjek om URL er sat og dens længde er større end 0
if (isset($URL) && strlen($URL) > 0) {

    // Etabler databaseforbindelse
    require("connection.php");
    
    // Sanitiser og trim brugerinput for mediatitel og beskrivelse
    $mediaTitle = htmlspecialchars(trim($_POST['mediaTitle']));
    $mediaDesc = htmlspecialchars(trim($_POST['mediaDesc']));

    // Udfør denne kodeblok kun hvis en mediatitel og beskrivelse er angivet
    if (strlen($mediaTitle) > 0 && strlen($mediaDesc) > 0) {

        // Forbered SQL-forespørgsel til at indsætte data i 'Media'-tabellen
        $stmt1 = $conn->prepare("INSERT INTO Media (URL, mediaTitle, mediaDesc, mediaProfileFK) VALUES (?, ?, ?, ?)");
        
        // Bind parametre til den forberedte erklæring
        $stmt1->bind_param("sssi", $URL, $mediaTitle, $mediaDesc, $mediaProfileFK);

        // Sanitiser og trim URL
        $URL = htmlspecialchars(trim($URL));
        
        // Sæt en standardværdi for mediaProfileFK (antager 1 i dette tilfælde)
        $mediaProfileFK = 1;

        // Udfør den forberedte erklæring
        $stmt1->execute();

        // Luk den forberedte erklæring
        $stmt1->close();

        // Luk databaseforbindelsen
        $conn->close();
    } else {
        // Vis en fejlmeddelelse, hvis titel og beskrivelse ikke er angivet
        echo "Fejl: Titel og beskrivelse skal angives.";
    }

} else {
    // Vis en fejlmeddelelse, hvis URL (billede) ikke er angivet
    echo "Fejl: URL (billede) skal angives.";
}
?>