<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Categoria.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = new Database();
    $db = $database->getConnection();
    $categoria = new Categoria($db);

    if (!empty($_GET['id'])) {
        $categoria->id = $_GET['id'];

        if ($categoria->buscaID()) {
            if ($categoria->excluir()) {
                header("Location: categorias.php?sucesso=2"); //categoria excluida
                exit();
            } else {
                header("Location: categorias.php?erro=4"); //categoria nao excluida
                exit();
            }
        } else {
            header("Location: categorias.php?erro=8"); //categoria nao existente
            exit();
        }
    } else {
        header("Location: categorias.php?erro=5"); //campo id vazio
        exit();
    }
} else {
    header("Location: categorias.php?erro=3"); //se o metodo nao for post
}
