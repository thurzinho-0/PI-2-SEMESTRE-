<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Categoria.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $categoria = new Categoria($db);

    if (!empty($_POST['id']) && !empty($_POST['nome'])) {
        $categoria->id = $_POST['id'];
        $categoria->nome = $_POST['nome'];

        if ($categoria->categoriaExiste()) {
            $_SESSION['msg_erro'] = $mensagens['categoria_duplicada'];
            header("Location: categorias.php");
            exit();
        }
        if ($categoria->editar()) {
            $_SESSION['msg_sucesso'] = $mensagens['categoria_editada'];
        } else {
            $_SESSION['msg_erro'] = $mensagens['categoria_nao_editada'];
        }
        header("Location: categorias.php");
        exit();
    } else {
        $_SESSION['msg_erro'] = $mensagens['id_vazio'];
        header("Location: categorias.php"); //campo id ou nome vazio
        exit();
    }
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: categorias.php"); //se o metodo nao for post
    exit();
}
