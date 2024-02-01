<?php
class NewUser
{
    // Variabel til at gemme beskeder om oprettelsesstatus
    public $message;

    // Konstruktørmetode til at oprette en ny bruger
    public function __construct($Fname, $Lname, $Email, $Username, $Pass)
    {
        // Udfør valideringer på formdata
        $db = new DbCon();
        
        // Trim de indtastede værdier for at fjerne ekstra whitespace
        $Fname = trim($_POST['Fname']);
        $Lname = trim($_POST['Lname']);
        $Email = trim($_POST['Email']);
        $Username = trim($_POST['Username']);
        $Pass = trim($_POST['Pass']);

        // Angiv antal iterationer for bcrypt-hashing
        $iterations = ['cost' => 15];

        // Hash adgangskoden med bcrypt
        $hashed_password = password_hash($Pass, PASSWORD_BCRYPT, $iterations);

        // Forbered en SQL-forespørgsel for at indsætte brugeroplysninger i databasen
        $profile = $db->dbCon->prepare("INSERT INTO `Profile` (Fname, Lname, Email, Username, Pass) VALUES ('{$Fname}', '{$Lname}','{$Email}', '{$Username}', '{$hashed_password}')");

        // Udfør SQL-forespørgslen og tjek om oprettelsen lykkedes
        if ($profile->execute()) {
            // Bruger oprettet succesfuldt
            $this->message = "Bruger oprettet.";
            
            // Omdiriger til login-siden
            header("Location: login.php");
            exit;
        } else {
            // Bruger kunne ikke oprettes
            $this->message = "Bruger kunne ikke oprettes.";
        }

        // Luk databaseforbindelsen
        $db->DBClose();
    }
}
?>