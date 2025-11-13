<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Produto.php');
$mensagens = include('../config/mensagens.php');

$pasta_uploads = "../assets/uploads/";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET['id_produto']) || empty($_GET['id_produto'])) {
        $_SESSION['msg_erro'] = "Produto não identificado.";
        header("Location: produtos.php");
        exit();
    }
    $id_produto = $_GET['id_produto'];

    if (!isset($_GET['id_imagem']) || empty($_GET['id_imagem'])) {
        $_SESSION['msg_erro'] = "Imagem não identificada.";
        header("Location: gerenciar_variacoes.php?id_produto=" . $id_produto);
        exit();
    }
    $id_img = $_GET['id_imagem'];

    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);
    $produto->id = $id_produto;

    $nome_arquivo = $produto->buscaImagem($id_img);

    if ($nome_arquivo) {
        $caminho_completo = $pasta_uploads . $nome_arquivo;
        
        if (file_exists($caminho_completo)) {
            unlink($caminho_completo);
        }
    }

    if ($produto->excluirImagem($id_img)) {
        $_SESSION['msg_sucesso'] = "Imagem excluída com sucesso";
    } else {
        $_SESSION['msg_erro'] = "Erro ao excluir a imagem.";
    }

    header("Location: gerenciar_variacoes.php?id_produto=" . $id_produto);
    exit();

} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: produtos.php");
    exit();
}
?>
