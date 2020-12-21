<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pdf";

// Create connection
$connect = new mysqli($servername, $username, $password, $dbname);

if ($connect === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
