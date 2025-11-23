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

        if ($cor->CorEmUso()) {
            if ($cor->inativar()) {
                $_SESSION['msg_sucesso'] = $mensagens['cor_inativada'];
                header("Location: cor.php"); //cor inativada
                exit();
            } else {
                $_SESSION['msg_erro'] = $mensagens['cor_nao_inativada'];
                header("Location: cor.php"); //cor nao inativada
                exit();
            }
        } else {
            if ($cor->excluir()) {
                $_SESSION['msg_sucesso'] = $mensagens['cor_excluida'];
                header("Location: cor.php"); //cor excluida
                exit();
            } else {
                $_SESSION['msg_erro'] = $mensagens['cor_nao_excluida'];
                header("Location: cor.php"); //cor nao excluida
                exit();
            }
        }
    } else {
        $_SESSION['msg_erro'] = $mensagens['campos_vazios'];
        header("Location: cor.php"); //campo id vazio
        exit();
    }
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: cor.php"); //se o metodo nao for post
    exit();
}