<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Cor.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $cor = new Cor($db);

    if (!empty($_POST['id']) && !empty($_POST['nome'])) {
        $cor->id = $_POST['id'];
        $cor->nome = $_POST['nome'];

        if ($cor->CorExiste()) {
            $_SESSION['msg_erro'] = $mensagens['cor_duplicada'];
            header("Location: cor.php");
            exit();
        }
        if ($cor->editar()) {
            $_SESSION['msg_sucesso'] = $mensagens['cor_editada'];
        } else {
            $_SESSION['msg_erro'] = $mensagens['cor_nao_editada'];
        }
        header("Location: cor.php");
        exit();
    } else {
        $_SESSION['msg_erro'] = $mensagens['id_vazio'];
        header("Location: cor.php?"); //campo id ou nome vazio
        exit();
    }
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: cor.php"); //se o metodo nao for post
    exit();
}
