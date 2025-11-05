<?php 
session_start();
if(!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] !== 'admin'){
    header("Location: ../login.php?erro=2");
    exit();
}

?>