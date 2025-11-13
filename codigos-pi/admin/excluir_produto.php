<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Produto.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);

    if (empty($_GET['id'])) {
        $_SESSION['msg_erro'] = $mensagens['id_vazio'];
        header("Location: produtos.php");
        exit();
    }

    $produto->id = $_GET['id'];

    if ($produto->produtoEmUso()) {

        if ($produto->inativar()) {
            $_SESSION['msg_sucesso'] = $mensagens['produto_inativado'];
            header("Location: produtos.php");
            exit();
        } else {
            $_SESSION['msg_erro'] = $mensagens['produto_nao_inativado'];
            header("Location: produtos.php");
            exit();
        }
    } else {

        if ($produto->excluir()) {
            $_SESSION['msg_sucesso'] = $mensagens['produto_excluido'];
            header("Location: produtos.php");
            exit();
        } else {
            $_SESSION['msg_erro'] = $mensagens['produto_nao_excluido'];
            header("Location: produtos.php");
            exit();
        }
    }
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: produtos.php");
    exit();
}
