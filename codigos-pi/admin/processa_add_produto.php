<?php

require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Produto.php');
$mensagens = include('../config/mensagens.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $pasta_uploads = "../assets/uploads/";
    $nome_arquivo_banco = null;

    if (
        empty($_POST['nome']) ||
        empty($_POST['fk_categoria_id']) ||
        empty($_POST['preco'])
    ) {
        $_SESSION['msg_erro'] = $mensagens['campos_vazios'];
        header("Location: add_produto.php");
        exit();
    }

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0 && $_FILES['imagem']['size'] > 0) {

        $tipos_permitidos = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp'
        ];
        $tipo_arquivo = $_FILES['imagem']['type'];

        if (in_array($tipo_arquivo, $tipos_permitidos)) {

            $arquivo_tmp = $_FILES['imagem']['tmp_name'];
            $nome_original = $_FILES['imagem']['name'];
            $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
            $nome_arquivo_banco = uniqid() . '_' . pathinfo($nome_original, PATHINFO_FILENAME) . '.' . $extensao;
            $caminho_final = $pasta_uploads . $nome_arquivo_banco;

            if (!move_uploaded_file($arquivo_tmp, $caminho_final)) {
                $_SESSION['msg_erro'] = $mensagens['upload_falhou'];
                header("Location: add_produto.php");
                exit();
            }
        } else {
            $_SESSION['msg_erro'] = $mensagens['arquivo_invalido'];
            header("Location: add_produto.php");
            exit();
        }
    }

    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);

    $produto->nome = $_POST['nome'];
    $produto->fk_categoria_id = $_POST['fk_categoria_id'];
    $produto->descricao = $_POST['descricao'];
    $produto->preco = $_POST['preco'];
    $produto->imagem = $nome_arquivo_banco;

    if ($produto->criar()) {
        $_SESSION['msg_sucesso'] = $mensagens['produto_criado'];
        $id_novo_produto = $db->insert_id;
        
        header("Location: produtos.php");
        // header("Location: gerenciar_variacoes.php?id_produto=" . $id_novo_produto . "&novo=1");
        exit();
    } else {
        $_SESSION['msg_erro'] = $mensagens['produto_nao_criado'];
        header("Location: add_produto.php");
        exit();
    }
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: produtos.php");
    exit();
}
