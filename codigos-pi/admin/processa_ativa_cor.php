<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Cor.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = new Database();
    $db = $database->getConnection();
    $cor = new Cor($db);

    if (!empty($_GET['id'])) {
        $cor->id = $_GET['id'];

        if ($cor->reativar()) {
            $_SESSION['msg_sucesso'] = $mensagens['cor_reativada'];
            header("Location: cor.php"); //cor reativada
            exit();
        } else {
            $_SESSION['msg_erro'] = $mensagens['cor_nao_reativada'];
            header("Location: cor.php"); //cor nao reativada 
            exit();
        }
    } else {
        $_SESSION['msg_erro'] = $mensagens['id_vazio'];
        header("Location: cor.php"); //campo id ou nome vazio
        exit();
    }
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: cor.php"); //se o metodo nao for post
    exit();
}
