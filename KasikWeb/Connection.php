<?php
$server = "localhost";
$username = "root";
$password = "root";
$dbname = "kasikweb";

$conn = mysqli_connect($server, $username, $password, $dbname);

if (!$conn) {
    die("Připojení k databázi selhalo: " . mysqli_connect_error());
}
?>
