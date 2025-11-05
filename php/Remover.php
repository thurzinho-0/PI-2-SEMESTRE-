<?php
    session_start();

    if (isset($_GET['id'])) {
        $id_remover = $_GET['id'];

        if (isset($_SESSION['carrinho'][$id_remover])) {
            unset($_SESSION['carrinho'][$id_remover]);
        }
    }

    header('Location: ../carrinho.php');
    exit;
?>