<?php
require ("constants.php");
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS);
if(!$conn) {
    die("Error!");
}
$conn->select_db(DB_NAME);
