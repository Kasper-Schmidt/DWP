<?php
class Logoutor
{
    // Konstruktørmetode til at logge brugeren ud
    public function __construct()
    {
        // Fire trin til at afslutte en session (dvs. logge ud)

        // 1. Find sessionen
        // Dette gøres med session_start() i sessionhåndteringsklassen

        // 2. Unset alle sessionvariabler
        $_SESSION = array();

        // 3. Ødelæg sessionens cookie
        if (isset($_COOKIE[session_name()])) {
            // Sætter cookiens udløbstid til et tidligere tidspunkt
            setcookie(session_name(), '', time() - 42000, '/');
        }

        // 4. Ødelæg sessionen
        session_destroy();
    }
}
?>