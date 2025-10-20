<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Categoria.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $categoria = new Categoria($db);

    if (!empty($_POST['id']) && !empty($_POST['nome'])) {
        $categoria->id = $_POST['id'];
        $categoria->nome = $_POST['nome'];

        if ($categoria->editar()) {
            header("Location: categorias.php?sucesso=3"); //categoria editada
            exit();
        } else {
            header("Location: categorias.php?erro=6"); //categoria nao editada 
            exit();
        }
    } else {
        header("Location: categorias.php?erro=7"); //campo id ou nome vazio
        exit();
    }
} else {
    header("Location: categorias.php?erro=3"); //se o metodo nao for post
}
