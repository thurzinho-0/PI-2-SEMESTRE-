<?php
session_start();

require_once 'classes/Database.php';
require_once 'classes/Usuario.php';
$mensagens = include('config/mensagens.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $usuario = new Usuario($db);

    $usuario->email = $_POST['email'];
    $usuario->senha = $_POST['senha'];

    if ($usuario->login()) {
        $_SESSION['id'] = $usuario->id;
        $_SESSION['usuario'] = $usuario->nome;
        $_SESSION['tipo_usuario'] = $usuario->tipo_usuario;

        if ($usuario->tipo_usuario == 'admin') {
            $_SESSION['msg_sucesso'] = $mensagens['login'];
            header("Location: admin/controle.php");
            exit();
        } else {
            $_SESSION['msg_sucesso'] = $mensagens['login'];
            header("Location: cliente/home.php");
            exit();
        }
    } else {
        $_SESSION['msg_erro'] = $mensagens['falha_login'];
        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION['msg_sucesso'] = $mensagens['requisicao_invalida'];
    header("Location: login.php");
    exit();
}
