<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Produto.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);

    if (!empty($_POST['nome'])) {
        $produto->nome = $_POST['nome'];
        $produto->fk_categoria_id = $_POST['fk_categoria_id'];
        $produto->descricao = $_POST['descricao'];
        $produto->preco = $_POST['preco'];

        if ($produto->criar()) {
            header("Location: produtos.php?sucesso=1"); //produto cadastrada
            exit();
        } else {
            header("Location: produtos.php?erro=1"); //produto nao cadastrada 
            exit();
        }
    } else {
        header("Location: produtos.php?erro=2"); //campo nome vazio
        exit();
    }
} else {
    header("Location: produtos.php?erro=3"); //se o metodo nao for post
}
