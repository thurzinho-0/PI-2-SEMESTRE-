<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Categoria.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $categoria = new Categoria($db);

    if (!empty($_POST['nome'])) {
        $categoria->nome = $_POST['nome'];

        if ($categoria->criar()) {
            header("Location: categorias.php?sucesso=1"); //categoria cadastrada
            exit();
        } else {
            header("Location: categorias.php?erro=1"); //categoria nao cadastrada 
            exit();
        }
    } else {
        header("Location: categorias.php?erro=2"); //campo nome vazio
        exit();
    }
} else {
    header("Location: categorias.php?erro=3"); //se o metodo nao for post
}
