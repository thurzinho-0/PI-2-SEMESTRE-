<?php
// verifica_estoque.php

// Desativa erros visuais para não quebrar o JSON
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');

// --- SEUS DADOS DE CONEXÃO ---
// Certifique-se que o XAMPP (MySQL) está ligado!
$host = '127.0.0.1';
$user = 'root';
$pass = '';  // Se o seu XAMPP tem senha, coloque aqui. Se não, deixe vazio.
$db   = 'cxstorebd';

$response = [
    'disponivel' => false,
    'erro_debug' => null // Aqui vai aparecer o motivo se falhar
];

if (isset($_POST['produto_id'], $_POST['tamanho_nome'], $_POST['cor_id'])) {
    
    $p_id = (int)$_POST['produto_id'];
    $c_id = (int)$_POST['cor_id'];
    $t_nome = $_POST['tamanho_nome'];

    try {
        // Tenta conectar
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Faz a consulta
        $sql = "SELECT COUNT(vp.id) 
                FROM variacao_produto vp
                JOIN tamanho t ON vp.fk_tamanho_id = t.id
                WHERE vp.fk_produto_anuncio_id = :pid 
                  AND vp.fk_cor_id = :cid 
                  AND t.nome = :tnome 
                  AND vp.disponivel = 1";
                  
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':pid' => $p_id, ':cid' => $c_id, ':tnome' => $t_nome]);
        
        // Verifica se achou
        if ($stmt->fetchColumn() > 0) {
            $response['disponivel'] = true;
        } else {
             // Opcional: Avisa que não achou no banco (para debug)
             $response['erro_debug'] = 'Conectou, mas não achou estoque para essa combinação.';
        }

    } catch (PDOException $e) { 
        // SE DER ERRO DE SENHA/BANCO, VAI APARECER AQUI
        $response['erro_debug'] = 'Erro no Banco: ' . $e->getMessage();
    }
}

echo json_encode($response);
?>