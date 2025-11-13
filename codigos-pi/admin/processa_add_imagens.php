<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Produto.php');
$mensagens = include('../config/mensagens.php');

$pasta_uploads = "../assets/uploads/";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['id_produto']) || empty($_POST['id_produto'])) {
        $_SESSION['msg_erro'] = $mensagens['id_vazio'];
        header("Location: produtos.php");
        exit();
    }

    $id_produto = $_POST['id_produto'];

    if (!isset($_FILES['imagens']) || empty($_FILES['imagens']['name'][0])) {
        $_SESSION['msg_erro'] = "Nenhuma imagem foi selecionada.";
        header("Location: gerenciar_variacoes.php?id_produto=" . $id_produto);
        exit();
    }

    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);
    $produto->id = $id_produto;

    $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    $sucesso = 0;
    $erro = 0;

    $total_arquivos = count($_FILES['imagens']['name']);

    for ($i = 0; $i < $total_arquivos; $i++) {
        $nome_original = $_FILES['imagens']['name'][$i];
        $tipo_arquivo = $_FILES['imagens']['type'][$i];
        $arquivo_tmp = $_FILES['imagens']['tmp_name'][$i];
        $erro_arquivo = $_FILES['imagens']['error'][$i];

        if ($erro_arquivo != 0) {
            $erro++;
            continue;
        }

        if (in_array($tipo_arquivo, $tipos_permitidos)) {
            $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
            $nome_arquivo_banco = uniqid() . '_' . pathinfo($nome_original, PATHINFO_FILENAME) . '.' . $extensao;
            $caminho_final = $pasta_uploads . $nome_arquivo_banco;

            if (move_uploaded_file($arquivo_tmp, $caminho_final)) {
                if ($produto->adicionarImagemSecundaria($nome_arquivo_banco)) {
                    $sucesso++;
                } else {
                    $erro++;
                }
            } else {
                $erro++;
            }
        } else {
            $erro++;
        }
    }

    if ($sucesso == 1) {
        $_SESSION['msg_sucesso'] = "$sucesso imagem adicionada com sucesso";
    } else if ($sucesso > 1) {
        $_SESSION['msg_sucesso'] = "$sucesso imagens adicionadas com sucesso";
    }

    if ($erro == 1) {
        $_SESSION['msg_erro'] = "$erro imagem falhou ao ser enviada";
    } else if ($erro > 1) {
        $_SESSION['msg_erro'] = "$erro imagens falharam ao ser enviadas";
    }

    header("Location: gerenciar_variacoes.php?id_produto=" . $id_produto);
    exit();
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: produtos.php");
    exit();
}
