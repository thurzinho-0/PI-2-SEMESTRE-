<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Cor.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = new Database();
    $db = $database->getConnection();
    $cor = new Cor($db);

    if (!empty($_GET['id'])) {
        $cor->id = $_GET['id'];

        if ($cor->CorEmUso()) {
            if ($cor->inativar()) {
                header("Location: cor.php?sucesso=4"); //cor inativada
                exit();
            } else {
                header("Location: cor.php?erro=9"); //cor nao inativada
                exit();
            }
        } else {
            if ($cor->excluir()) {
                header("Location: cor.php?sucesso=2"); //cor excluida
                exit();
            } else {
                header("Location: cor.php?erro=4"); //cor nao excluida
                exit();
            }
        }
    } else {
        header("Location: cor.php?erro=5"); //campo id vazio
        exit();
    }
} else {
    header("Location: cor.php?erro=3"); //se o metodo nao for post
}
