<?php
require_once('../classes/Database.php');
require_once('../classes/Produto.php');

$database = new Database();
$db = $database->getConnection();

$produto = new Produto($db);

if (isset($_POST['id'], $_POST['status'])) {
    $produto->id = $_POST['id'];
    $produto->status = $_POST['status'];
    $produto->editarStatus();
}
?>