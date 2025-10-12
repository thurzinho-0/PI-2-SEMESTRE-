<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$bdnome = "cxstorebd";

// Create connection
$conn = mysqli_connect($servidor, $usuario, $senha, $bdnome);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>