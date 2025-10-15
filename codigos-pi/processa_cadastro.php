<?php 

require_once('classes/Database.php');
require_once('classes/Usuario.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $database = new Database();
    $db = $database->getConnection();
    $usuario = new Usuario($db);

    $usuario->nome = $_POST['nome'];
    $usuario->email = $_POST['email'];
    $usuario->senha = $_POST['senha'];
    $usuario->contato = $_POST['contato'];

    $usuario->tipo_usuario = 'cliente';

    if ($usuario->emailExiste()){
        header("Location: cadastro.php?erro=2");
        exit();
    }

    if ($usuario->cadastrar()){
        header("Location: login.php?sucesso=1");
        exit();
    } else{
        header("Location: cadastro.php?erro=1");
        exit();
    }
} else{
    header("Location: cadastro.php");
    exit();
}
?>