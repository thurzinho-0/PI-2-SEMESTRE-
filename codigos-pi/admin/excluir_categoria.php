<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Categoria.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = new Database();
    $db = $database->getConnection();
    $categoria = new Categoria($db);

    if (!empty($_GET['id'])) {
        $categoria->id = $_GET['id'];

        if ($categoria->categoriaEmUso()) {
            if ($categoria->inativar()) {
                $_SESSION['msg_sucesso'] = $mensagens['categoria_inativada'];
                header("Location: categorias.php");
                exit();
            } else {
                $_SESSION['msg_erro'] = $mensagens['categoria_nao_inativada'];
                header("Location: categorias.php");
                exit();
            }
        } else {
            if ($categoria->excluir()) {
                $_SESSION['msg_sucesso'] = $mensagens['categoria_excluida'];
                header("Location: categorias.php");
                exit();
            } else {
                $_SESSION['msg_erro'] = $mensagens['categoria_nao_excluida'];
                header("Location: categorias.php");
                exit();
            }
        }
    } else {
        $_SESSION['msg_erro'] = $mensagens['id_vazio'];
        header("Location: categorias.php");
        exit();
    }
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: categorias.php");
    exit();
}
