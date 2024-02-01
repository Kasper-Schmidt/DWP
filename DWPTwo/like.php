<?php
// Starter sessionshåndtering
session_start();

// Viser indholdet af sessionen (til testformål)
var_dump($_SESSION);

// Kræver databaseforbindelse
require("connection.php");

// Håndter LIKE-anmodningen
// Tjek om brugeren er logget ind
if (isset($_SESSION['userid'])) { 
    // Hent brugerens ID fra sessionen
    $user_id = $_SESSION['userid']; 
    
    // Tjek om formularen blev sendt korrekt
    if (isset($_POST['like_action'], $_POST['MediaLikeFK'])) {
        // Bestem handlingen baseret på brugerens valg (Like eller Unlike)
        $like_action = ($_POST['like_action'] == 'Like') ? 1 : -1;
        $media_id = htmlspecialchars(trim($_POST['MediaLikeFK']));
        
        // Tjek om brugeren allerede har liket billedet
        $stmt_check = $conn->prepare("SELECT * FROM Likes WHERE MediaLikeFK = ? AND ProfileLikeFK = ?");
        $stmt_check->bind_param("ii", $media_id, $user_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $stmt_check->close();
        
        if ($result_check->num_rows > 0) {
            // Brugeren har allerede liket billedet, udfør en OPDATERING
            $stmt = $conn->prepare("UPDATE Likes SET LikeAmount = ? WHERE MediaLikeFK = ? AND ProfileLikeFK = ?");
            $stmt->bind_param("iii", $like_action, $media_id, $user_id);
        } else {
            // Brugeren har ikke liket billedet, udfør en INDSETTING
            $stmt = $conn->prepare("INSERT INTO Likes (LikeAmount, MediaLikeFK, ProfileLikeFK) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $like_action, $media_id, $user_id);
        }
        
        // Tjek forberedelsen af SQL-forespørgslen
        if (!$stmt) {
            die("Forberedelse mislykkedes: " . $conn->error);
        }
        
        // Udfør SQL-forespørgslen og tjek for fejl
        if (!$stmt->execute()) {
            die("Fejl ved udførelse af forespørgsel: " . $stmt->error);
        } else {
            echo "Handling udført!";
        }

        // Luk det forberedte udsagn
        $stmt->close();
    } else {
        die("Formularen blev ikke sendt korrekt.");
    }
} else {
    echo "Du skal være logget ind for at kunne like billeder.";
}

// Luk databaseforbindelsen
$conn->close();
?>