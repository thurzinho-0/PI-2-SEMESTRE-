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

        if ($tamanho->TamanhoEmUso()) {
            if ($tamanho->inativar()) {
                $_SESSION['msg_sucesso'] = $mensagens['tamanho_inativado'];
                header("Location: tamanho.php"); //tamanho inativado
                exit();
            } else {
                $_SESSION['msg_erro'] = $mensagens['tamanho_nao_inativado'];
                header("Location: tamanho.php"); //tamanho nao inativado
                exit();
            }
        } else {
            if ($tamanho->excluir()) {
                $_SESSION['msg_sucesso'] = $mensagens['tamanho_excluido'];
                header("Location: tamanho.php"); //tamanho excluido
                exit();
            } else {
                $_SESSION['msg_erro'] = $mensagens['tamanho_nao_excluido'];
                header("Location: tamanho.php"); //tamanho nao excluido
                exit();
            }
        }
    } else {
        $_SESSION['msg_erro'] = $mensagens['id_vazio'];
        header("Location: tamanho.php"); //campo id vazio
        exit();
    }
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: tamanho.php"); //se o metodo nao for post
    exit();
}
