<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Cor.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $cor = new Cor($db);

    if (!empty($_POST['nome'])) {
        $cor->nome = $_POST['nome'];

        if ($cor->criar()) {
            $_SESSION['msg_sucesso'] = $mensagens['cor_criada'];
            header("Location: cor.php");
            exit();
        } else {
            $_SESSION['msg_erro'] = $mensagens['cor_nao_criada'];
            header("Location: cor.php");
            exit();
        }
    } else {
        $_SESSION['msg_erro'] = $mensagens['campos_vazios'];
        header("Location: cor.php");
        exit();
    }
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: cor.php");
    exit();
}
