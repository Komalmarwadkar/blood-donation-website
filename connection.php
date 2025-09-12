<?php
$host = "localhost";   // server name
$user = "root";        // default username in XAMPP
$pass = "";            // default password is blank
$db   = "donatetheblood";  // apna database ka naam likho

$connection = mysqli_connect($host, $user, $pass, $db);

if (!$connection) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>