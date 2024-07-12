<?php
$servername = "sql309.infinityfree.com";
$username = "if0_36583164";
$password = "adamsilini2010";
$dbname = "if0_36583164_xspy"; // if0_36583164_XXX

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>