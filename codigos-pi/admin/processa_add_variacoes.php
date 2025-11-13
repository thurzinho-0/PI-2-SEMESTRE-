<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Produto.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_POST['id_produto']) || empty($_POST['id_produto'])) {
        $_SESSION['msg_erro'] = $mensagens['id_vazio'];
        header("Location: produtos.php");
        exit();
    }

    $id_produto = $_POST['id_produto'];

    $cores_selecionadas = $_POST['cores'] ?? [];
    $tamanhos_selecionados = $_POST['tamanhos'] ?? [];

    if (empty($cores_selecionadas) || empty($tamanhos_selecionados)) {
        $_SESSION['msg_erro'] = "Você deve selecionar pelo menos uma cor e um tamanho para criar variações.";
        header("Location: gerenciar_variacoes.php?id_produto=" . $id_produto);
        exit();
    }

    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);
    $produto->id = $id_produto;

    $sucesso = 0;
    $erro = 0;

    foreach ($cores_selecionadas as $id_cor) {
        foreach ($tamanhos_selecionados as $id_tamanho) {
            if ($produto->adicionarVariacao($id_cor, $id_tamanho)) {
                $sucesso++;
            } else {
                $erro++;
            }
        }
    }

    if ($sucesso == 1) {
        $_SESSION['msg_sucesso'] = "$sucesso nova variação foram criadas";
    } else if ($sucesso > 1) {
        $_SESSION['msg_sucesso'] = "$sucesso novas variações foram criadas";
    }

    if ($erro == 1) {
        $_SESSION['msg_erro'] = "$erro variação já existe ou falharam.";
    } else if ($erro > 1) {
        $_SESSION['msg_erro'] = "$erro variações já existem ou falharam.";
    }

    header("Location: gerenciar_variacoes.php?id_produto=" . $id_produto);
    exit();
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: produtos.php");
    exit();
}
