<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Cor.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $cor = new Cor($db);

    if (!empty($_POST['id']) && !empty($_POST['nome'])) {
        $cor->id = $_POST['id'];
        $cor->nome = $_POST['nome'];

        if ($cor->editar()) {
            header("Location: cor.php?sucesso=3"); //cor editada
            exit();
        } else {
            header("Location: cor.php?erro=6"); //cor nao editada 
            exit();
        }
    } else {
        header("Location: cor.php?erro=7"); //campo id ou nome vazio
        exit();
    }
} else {
    header("Location: cor.php?erro=3"); //se o metodo nao for post
}
