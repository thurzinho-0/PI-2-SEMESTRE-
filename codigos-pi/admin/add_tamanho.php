<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Tamanho.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $tamanho = new Tamanho($db);

    if (!empty($_POST['nome'])) {
        $tamanho->nome = $_POST['nome'];

        if ($tamanho->criar()) {
            $_SESSION['msg_sucesso'] = $mensagens['tamanho_criado'];
            header("Location: tamanho.php"); //tamanho cadastrado
            exit();
        } else {
            $_SESSION['msg_erro'] = $mensagens['tamanho_nao_criado'];
            header("Location: tamanho.php"); //tamanho nao cadastrado
            exit();
        }
    } else {
        $_SESSION['msg_erro'] = $mensagens['campos_vazios'];
        header("Location: tamanho.php"); //campo nome vazio
        exit();
    }
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: tamanhos.php"); //se o metodo nao for post
    exit();
}
