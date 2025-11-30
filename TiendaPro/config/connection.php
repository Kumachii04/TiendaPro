<?php
   
$conn = new mysqli("localhost", "root", "informatica", "comercio_electronico");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8");

?>