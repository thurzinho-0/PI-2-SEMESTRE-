<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Produto.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);

    if (!empty($_POST['id']) && !empty($_POST['nome'])) {
        $produto->id = $_POST['id'];
        $produto->status = $_POST['status'];
        $produto->nome = $_POST['nome'];
        $produto->fk_categoria_id = $_POST['fk_categoria_idca'];
        $produto->descricao = $_POST['descricao'];
        $produto->preco = $_POST['preco'];

        if ($produto->editar()) {
            header("Location: produtos.php?sucesso=3"); //produto editada
            exit();
        } else {
            header("Location: produtos.php?erro=6"); //produto nao editada 
            exit();
        }
    } else {
        header("Location: produtos.php?erro=7"); //campo id ou nome vazio
        exit();
    }
} else {
    header("Location: produtos.php?erro=3"); //se o metodo nao for post
}
