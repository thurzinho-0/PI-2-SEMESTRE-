<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Tamanho.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = new Database();
    $db = $database->getConnection();
    $tamanho = new Tamanho($db);

    if (!empty($_GET['id'])) {
        $tamanho->id = $_GET['id'];

        if ($tamanho->reativar()) {
            $_SESSION['msg_sucesso'] = $mensagens['tamanho_reativado'];
            header("Location: tamanho.php"); //tamanho reativado
            exit();
        } else {
            $_SESSION['msg_erro'] = $mensagens['tamanho_nao_reativado'];
            header("Location: tamanho.php"); //tamanho nao reativado
            exit();
        }
    } else {
        $_SESSION['msg_erro'] = $mensagens['id_vazio'];
        header("Location: tamanho.php?"); //campo id ou nome vazio
        exit();
    }
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: tamanho.php"); //se o metodo nao for post
    exit();
}
