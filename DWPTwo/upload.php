<?php
if (isset($_POST['submit'])) { // Tjek om formen er blevet indsendt
    if (
        (
            ($_FILES['picture']['type'] == "image/gif") ||
            ($_FILES['picture']['type'] == "image/png") ||
            ($_FILES['picture']['type'] == "image/jpeg") ||
            ($_FILES['picture']['type'] == "image/jpg")
        ) && (
            ($_FILES['picture']['size'] < 1000000) && // Størrelsen skal være mindre end 1 Megabyte
            ($_FILES['picture']['error'] == 0) // Tjek for ingen upload-fejl
        )
    ) {
        list($width, $height) = getimagesize($_FILES['picture']['tmp_name']); // Hent billedets dimensioner

        // Minimum og maksimum dimensioner
        $minWidth = 200; // Minimum bredde
        $minHeight = 200; // Minimum højde
        $maxWidth = 4200; // Maksimal bredde
        $maxHeight = 4200; // Maksimal højde

        if ($width >= $minWidth && $height >= $minHeight && $width <= $maxWidth && $height <= $maxHeight) { // Tjek om dimensionerne er inden for acceptable grænser
            echo "Upload: " . $_FILES['picture']['name'] . "</br>"; // Vis upload meddelelse

            if (file_exists("img/" . $_FILES['picture']['name'])) { // Tjek om filen allerede eksisterer
                echo "Can't upload. File already there!"; // Vis fejlmeddelelse, hvis filen allerede findes
            } else {
                move_uploaded_file($_FILES['picture']['tmp_name'], "img/" . $_FILES['picture']['name']); // Flyt uploadet fil til destinationsmappen
                echo "Stored in: img/" . $_FILES['picture']['name']; // Vis meddelelse om, hvor filen er gemt

                $URL = "img/" . $_FILES['picture']['name']; // Opret variabel med stien til filen
            }
        } else {
            echo "Error: Billedets dimensioner skal være mellem $minWidth x $minHeight og $maxWidth x $maxHeight pixels."; // Vis fejlmeddelelse for uacceptable dimensioner
        }
    } else {
        echo "Error: Ugyldig filtype eller størrelse."; // Vis fejlmeddelelse for ugyldig filtype eller størrelse
    }
}

spl_autoload_register(function ($class){ // Automatisk indlæsning af klasser
    include $class.".php"; // Inkluder den påkrævede klassefil
});

define("MAXSIZE", 3000); // Definer maksimal filstørrelse i kilobytes
$upmsg = array(); // Opret en tom besked-array til uploadstatus

if (isset($_POST['submit'])) { // Tjek om formen er blevet indsendt igen
    if ($_FILES['image']['name']) { // Tjek om der er valgt en fil
        $imageName = $_FILES['image']['name']; // Hent filnavnet
        $file = $_FILES['image']['tmp_name']; // Hent den midlertidige filsti
        $imageType = getimagesize($file); // Hent billedtypen
        if (($imageType[2] == 1) || ($imageType[2] == 2) || ($imageType[2] == 3)) { // Tjek om billedtypen er acceptabel
            $size = filesize($_FILES['image']['tmp_name']); // Hent filstørrelsen
            if ($size < MAXSIZE * 1024) { // Tjek om filstørrelsen er inden for den tilladte grænse
                $prefix = uniqid(); // Generer en unik præfiks
                $fileName = $prefix . "_" . $imageName; // Opret et unikt filnavn med præfikset
                $filePath = "img/" . $fileName; // Opret filstien

                // Yderligere tjek for minimum dimensioner
                $minWidth = 200; // Minimum bredde
                $minHeight = 200; // Minimum højde

                // Antager at Resizer-klassen har en metode til at få dimensionerne
                list($imageWidth, $imageHeight) = getimagesize($file); // Hent billedets dimensioner

                if ($imageWidth >= $minWidth && $imageHeight >= $minHeight) { // Tjek om dimensionerne er inden for acceptable grænser
                    $resOBJ = new Resizer(); // Opret en instans af Resizer-klassen
                    $resOBJ->load($file); // Indlæs billedet

                    if ($_POST['Rtype'] == "width") { // Tjek om ændringstype er bredde
                        $width = 324; // Ny bredde
                        $resOBJ->resizeToWidth($width); // Ændre bredden
                        array_push($upmsg, "Billedet er ændret til ny bredde på $width"); // Tilføj besked til besked-array
                    } elseif ($_POST['Rtype'] == "height") { // Tjek om ændringstype er højde
                        $height = 576; // Ny højde
                        $resOBJ->resizeToHeight($height); // Ændre højden
                        array_push($upmsg, "Billedet er ændret til ny højde på $height"); // Tilføj besked til besked-array
                    } elseif ($_POST['Rtype'] == "scale") { // Tjek om ændringstype er skala
                        $scale = $_POST['size']; // Ny skala
                        $resOBJ->scale($scale); // Ændre skalaen
                        array_push($upmsg, "Billedet er ændret til ny skala på $scale"); // Tilføj besked til besked-array
                    }

                    $resOBJ->save($filePath); // Gem det ændrede billede

                    // Tjek om dimensionerne opfylder kriterierne, før det indsættes i databasen
                    if ($imageWidth >= $minWidth && $imageHeight >= $minHeight) { // Yderligere tjek af dimensioner
                        $mysqli = new mysqli("localhost", "root", "123", "CocktailDB"); // Opret forbindelse til databasen
                        
                        // Undgå SQL Injection ved at undslippe brugerinput for sikkerhed
                        $escapedFilePath = $mysqli->real_escape_string($filePath); // Undslip filstien

                        $insertQuery = "INSERT INTO Media (filename) VALUES ('$escapedFilePath')";
                        
                        if ($mysqli->query($insertQuery) === TRUE) {
                            array_push($upmsg, "Success!");
                        } else {
                            // Delete the file if dimensions don't meet the criteria
                            unlink($filePath);
                            array_push($upmsg, "Error: Unable to insert into the database. " . $mysqli->error);
                        }
                    } else {
                        // Delete the file if dimensions don't meet the criteria
                        unlink($filePath);
                        array_push($upmsg, "Error: Image dimensions must be between $minWidth x $minHeight and $maxWidth x $maxHeight pixels. File not inserted into the database.");
                    }
                } else {
                    array_push($upmsg, "Error: Image dimensions must be greater than or equal to $minWidth x $minHeight pixels.");
                }
            } else {
                array_push($upmsg, "Error: Image size exceeds the maximum allowed size.");
            }
        }
    }
}
?>