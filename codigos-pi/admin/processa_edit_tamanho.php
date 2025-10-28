<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Tamanho.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $tamanho = new Tamanho($db);

    if (!empty($_POST['id']) && !empty($_POST['nome'])) {
        $tamanho->id = $_POST['id'];
        $tamanho->nome = $_POST['nome'];

        if ($tamanho->editar()) {
            header("Location: tamanho.php?sucesso=3"); //tamanho editado
            exit();
        } else {
            header("Location: tamanho.php?erro=6"); //tamanho nao editado 
            exit();
        }
    } else {
        header("Location: tamanho.php?erro=7"); //campo id ou nome vazio
        exit();
    }
} else {
    header("Location: tamanho.php?erro=3"); //se o metodo nao for post
}
