<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Tamanho.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $tamanho = new Tamanho($db);

    if (!empty($_POST['nome'])) {
        $tamanho->nome = $_POST['nome'];

        if ($tamanho->criar()) {
            header("Location: tamanho.php?sucesso=1"); //tamanho cadastrado
            exit();
        } else {
            header("Location: tamanho.php?erro=1"); //tamanho nao cadastrado
            exit();
        }
    } else {
        header("Location: tamanho.php?erro=2"); //campo nome vazio
        exit();
    }
} else {
    header("Location: tamanhos.php?erro=3"); //se o metodo nao for post
}
