<?php
require_once('sessao_admin.php');
require_once('../classes/Database.php');
require_once('../classes/Tamanho.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = new Database();
    $db = $database->getConnection();
    $tamanho = new Tamanho($db);

    if (!empty($_GET['id'])) {
        $tamanho->id = $_GET['id'];

        if ($tamanho->TamanhoEmUso()) {
            if ($tamanho->inativar()) {
                header("Location: tamanho.php?sucesso=4"); //tamanho inativado
                exit();
            } else {
                header("Location: tamanho.php?erro=9"); //tamanho nao inativado
                exit();
            }
        } else {
            if ($tamanho->excluir()) {
                header("Location: tamanho.php?sucesso=2"); //tamanho excluido
                exit();
            } else {
                header("Location: tamanho.php?erro=4"); //tamanho nao excluido
                exit();
            }
        }
    } else {
        header("Location: tamanho.php?erro=5"); //campo id vazio
        exit();
    }
} else {
    header("Location: tamanho.php?erro=3"); //se o metodo nao for post
}
