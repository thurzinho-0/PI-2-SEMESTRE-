<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Cor.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $cor = new Cor($db);

    if (!empty($_POST['nome'])) {
        $cor->nome = $_POST['nome'];

        if ($cor->criar()) {
            header("Location: cor.php?sucesso=1"); //cor cadastrada
            exit();
        } else {
            header("Location: cor.php?erro=1"); //cor nao cadastrada 
            exit();
        }
    } else {
        header("Location: cor.php?erro=2"); //campo nome vazio
        exit();
    }
} else {
    header("Location: cors.php?erro=3"); //se o metodo nao for post
}
