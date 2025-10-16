<?php 
session_start();
if(!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] !== 'cliente'){
    header("Location: ../login.php?erro=2");
    exit();
}

?>