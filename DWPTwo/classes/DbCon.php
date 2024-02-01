<?php
class DbCon
{
    // Brugernavn til databaseforbindelse
    private $Username = "root";

    // Adgangskode til databaseforbindelse
    private $Pass = "";

    // Databaseforbindelsesobjekt
    public $dbCon;

    // Konstruktørmetode for at oprette forbindelse til databasen
    public function __construct(){
        // Opretter en DSN-streng (Data Source Name) for PDO-forbindelsen
        $dsn = 'mysql:host=localhost;dbname=CocktailDB;charset=utf8';

        // Opretter en PDO-forbindelse med angivne brugernavn, adgangskode og DSN
        $this->dbCon = new PDO($dsn, $this->Username, $this->Pass);

        // Sætter fejlrapporterings- og undtagelsesindstillinger
        $this->dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Lukker databaseforbindelsen
    public function DBClose(){
        $this->dbCon = null;
    }

    // Henter information om, hvorvidt en bruger er administrator
    public function getUserIsAdmin($username) {
        // Forbereder en SQL-forespørgsel med en parameter (:username)
        $stmt = $this->dbCon->prepare("SELECT IsAdmin FROM Profile WHERE Username = :username");

        // Binder parameteren i forespørgslen til den faktiske brugernavnsværdi
        $stmt->bindParam(':username', $username);

        // Udfører SQL-forespørgslen
        $stmt->execute();

        // Henter resultatet som et associeret array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Returnerer værdien for 'IsAdmin' fra resultatet
        return $result['IsAdmin'];
    }
}
?>