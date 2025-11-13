<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Produto.php');
$mensagens = include('../config/mensagens.php');

$pasta_uploads = "../assets/uploads/";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);

    if (empty($_POST['id']) || empty($_POST['nome'])) {
        $_SESSION['msg_erro'] = $mensagens['campos_vazios'];
        header("Location: produtos.php");
        exit();
    }

    $produto->id = $_POST['id'];
    $produto->status = $_POST['status'];
    $produto->nome = $_POST['nome'];
    $produto->fk_categoria_id = $_POST['fk_categoria_id'];
    $produto->descricao = $_POST['descricao'];
    $produto->preco = $_POST['preco'];

    $sucesso_edicao = false;
    $sucesso_imagem = true;
    $nome_nova_imagem = $_POST['imagem_existente'] ?? null;

    if (isset($_FILES['nova_imagem']) && $_FILES['nova_imagem']['error'] == 0 && $_FILES['nova_imagem']['size'] > 0) {

        $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $tipo_arquivo = $_FILES['nova_imagem']['type'];

        if (in_array($tipo_arquivo, $tipos_permitidos)) {

            $arquivo_tmp = $_FILES['nova_imagem']['tmp_name'];
            $nome_original = $_FILES['nova_imagem']['name'];
            $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
            $nome_nova_imagem = uniqid() . '_' . pathinfo($nome_original, PATHINFO_FILENAME) . '.' . $extensao;
            $caminho_final = $pasta_uploads . $nome_nova_imagem;

            if (move_uploaded_file($arquivo_tmp, $caminho_final)) {

                $nome_imagem_antiga = $produto->atualizarImagem($nome_nova_imagem);

                if ($nome_imagem_antiga) {
                    $caminho_antigo = $pasta_uploads . $nome_imagem_antiga;
                    if (!empty($nome_imagem_antiga) && file_exists($caminho_antigo) && $nome_imagem_antiga != $nome_nova_imagem) {
                        unlink($caminho_antigo);
                    }
                } else if ($nome_imagem_antiga === false) {
                    $sucesso_imagem = false;
                    unlink($caminho_final);
                }
            } else {
                $sucesso_imagem = false;
            }
        } else {
            $sucesso_imagem = false;
            $_SESSION['msg_erro'] = $mensagens['arquivo_invalido'];
            header("Location: edit_produto.php?id=" . $produto->id);
            exit();
        }
    }

    if ($produto->editar() && $sucesso_imagem) {
        $_SESSION['msg_sucesso'] = $mensagens['produto_editado'];
        header("Location: produtos.php");
        exit();
    } else {
        $_SESSION['msg_erro'] = $mensagens['produto_nao_editado'];
        header("Location: produtos.php");
        exit();
    }
} else {
    $_SESSION['msg_erro'] = $mensagens['requisicao_invalida'];
    header("Location: produtos.php");
    exit();
}