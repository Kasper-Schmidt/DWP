<?php
// Kræver databaseforbindelse
require("connection.php");

// Hvis et brugernavn er angivet i GET-anmodningen
if (isset($_GET['Username'])) {
    // Hent brugernavnet fra GET-anmodningen
    $Username = $_GET['Username'];

    // Opdater brugerens blokeringsstatus i databasen
    $updateProfileQuery = "UPDATE `Profile` SET IsBlocked = 1 WHERE Username = ?";
    
    // Forbered en SQL-forespørgsel med placeholders og en forbindelsesressource
    $stmtProfile = mysqli_prepare($conn, $updateProfileQuery);
    
    // Binder brugernavnet til placeholderen i SQL-forespørgslen
    mysqli_stmt_bind_param($stmtProfile, "s", $Username);

    // Udfør SQL-forespørgslen og tjek for fejl
    if (!mysqli_stmt_execute($stmtProfile)) {
        die("Fejl ved blokering af bruger: " . mysqli_stmt_error($stmtProfile));
    } else {
        // Succesmeddelelse, hvis brugeren blev blokeret succesfuldt
        echo "Bruger blokeret succesfuldt";
    }

    // Luk forberedt udsagn
    mysqli_stmt_close($stmtProfile);
} else {
    // Omdiriger til forsiden, hvis brugernavnet ikke er angivet i GET-anmodningen
    header("Location: index.php");
}

// Luk databaseforbindelsen
mysqli_close($conn);
?>