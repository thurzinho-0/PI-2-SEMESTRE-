<?php 
    session_start();

    require_once 'classes/Database.php';
    require_once 'classes/Usuario.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $database = new Database();
        $db = $database->getConnection();
        $usuario = new Usuario($db);

        $usuario->email = $_POST['email'];
        $usuario->senha = $_POST['senha'];

        if ($usuario->login()){
            $_SESSION['id'] = $usuario->id;
            $_SESSION['usuario'] = $usuario->nome;
            $_SESSION['tipo_usuario'] = $usuario->tipo_usuario;

            if($usuario->tipo_usuario == 'admin'){
<<<<<<< HEAD
                header("Location: admin/controle.php");
=======
                header("Location: admin/painelanuncio.php");
>>>>>>> origin/backend
            } else {
                header("Location: cliente/home.php");
            }
            exit();
        } else {
            header("Location: login.php?erro=1");
        }
    } else {
        header("Location: login.php");
        exit();
    }
?>