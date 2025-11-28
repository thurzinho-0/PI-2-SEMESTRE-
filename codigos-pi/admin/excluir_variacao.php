<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Produto.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET['id_produto']) || empty($_GET['id_produto'])) {
        $_SESSION['msg_erro'] = "Produto não identificado para o redirecionamento.";
        header("Location: produtos.php");
        exit();
    }
    $id_produto = $_GET['id_produto'];

    if (!isset($_GET['id_variacao']) || empty($_GET['id_variacao'])) {
        $_SESSION['msg_erro'] = "Variação não identificada.";
        header("Location: gerenciar_variacoes.php?id_produto=" . $id_produto);
        exit();
    }
    $id = $_GET['id_variacao'];

    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);

    if ($produto->excluirVariacao($id)) {
        $_SESSION['msg_sucesso'] = "Variação excluída com sucesso";
    } else {
        $_SESSION['msg_erro'] = "Erro ao excluir a variação.";
    }

    header("Location: gerenciar_variacoes.php?id_produto=" . $id_produto);
    exit();
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: produtos.php");
    exit();
}
