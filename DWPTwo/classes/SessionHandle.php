<?php
class SessionHandle
{
    // Konstruktørmetode til at starte sessionen
    public function __construct()
    {
        session_start(); // Start sessionen
    }

    // Funktion til at kontrollere, om en bruger er logget ind
    public function logged_in()
    {
        return isset($_SESSION['ProfileID']) || isset($_SESSION['userid']);
    }

    // Funktion til at kontrollere, om en bruger er administrator
    public function isAdmin()
    {
        return isset($_SESSION['admin']) && $_SESSION['admin'] === 'admin';
    }

    // Funktion til at bekræfte, at en bruger er logget ind; ellers omdiriger til login-siden
    public function confirm_logged_in()
    {
        if (!$this->logged_in()) {
            // Opret en Redirector for at omdirigere brugeren til "login.php"
            $redirect = new Redirector("login.php");
        }
    }

    // Funktion til at ødelægge sessionen
    public function destroy()
    {
        // Frigør alle sessionvariabler
        session_unset();

        // Ødelæg sessionen
        session_destroy();
    }
}
?>