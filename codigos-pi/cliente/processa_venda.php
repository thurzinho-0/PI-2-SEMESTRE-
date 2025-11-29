<?php
session_start();
header('Content-Type: application/json');

require_once('../classes/Database.php');
require_once('../classes/Pedido.php');

if (!isset($_SESSION['id'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário não logado.']);
    exit;
}

$dados_brutos = file_get_contents('php://input');
$dados = json_decode($dados_brutos, true);

if (isset($dados['itens']) && isset($dados['total'])) {
    
    $database = new Database();
    $db = $database->getConnection();
    $pedido = new Pedido($db);

    $id_pedido = $pedido->criarPedidoCompleto($_SESSION['id'], $dados['total'], $dados['itens']);

    if ($id_pedido) {
        echo json_encode([
            'sucesso' => true, 
            'id_pedido' => $id_pedido
        ]);
    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao registrar pedido.']);
    }

} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados inválidos.']);
}
?>