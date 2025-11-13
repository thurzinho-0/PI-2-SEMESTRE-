<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Tamanho.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $tamanho = new Tamanho($db);

    if (!empty($_POST['id']) && !empty($_POST['nome'])) {
        $tamanho->id = $_POST['id'];
        $tamanho->nome = $_POST['nome'];

        if ($tamanho->TamanhoExiste()) {
            $_SESSION['msg_erro'] = $mensagens['tamanho_duplicado'];
            header("Location: tamanho.php");
            exit();
        }
        if ($tamanho->editar()) {
            $_SESSION['msg_sucesso'] = $mensagens['tamanho_editado'];
        } else {
            $_SESSION['msg_erro'] = $mensagens['tamanho_nao_editado'];
        }
        header("Location: tamanho.php");
        exit();
    } else {
        $_SESSION['msg_erro'] = $mensagens['campos_vazios'];
        header("Location: tamanho.php"); //campo id ou nome vazio
        exit();
    }
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: tamanho.php"); //se o metodo nao for post
    exit();
}
