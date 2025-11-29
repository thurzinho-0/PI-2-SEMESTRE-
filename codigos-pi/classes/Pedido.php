<?php

class Pedido
{
    private $conn;
    private $tabela_pedido = 'pedido';
    private $tabela_itens = 'pedido_item';
    private $tabela_usuario = 'usuario';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método de listagem de todos os pedidos (Admin)
    public function listarTodos()
    {
        $query = "SELECT p.*, u.nome as nome_cliente, u.email, u.contato
                  FROM " . $this->tabela_pedido . " p
                  LEFT JOIN " . $this->tabela_usuario . " u ON p.fk_usuario_id = u.id
                  ORDER BY p.data_criacao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Método de listagem de pedidos por usuário (Cliente)
    public function listarPorUsuario($usuario_id)
    {
        $query = "SELECT * FROM " . $this->tabela_pedido . "
                  WHERE fk_usuario_id = ?
                  ORDER BY data_criacao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Método de atualização de status do pedido (Admin)
    public function atualizarStatus($novo_status, $pedido_id)
    {
        $query = "UPDATE " . $this->tabela_pedido . " SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $novo_status, $pedido_id);
        return $stmt->execute();
    }

    // Método de criação de pedido completo (do carrinho)
    public function criarPedidoCompleto($usuario_id, $total, $itens)
    {
        $query = "INSERT INTO " . $this->tabela_pedido . " (fk_usuario_id, status, total, data_criacao) VALUES (?, 'pendente', ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("id", $usuario_id, $total);
        if ($stmt->execute()) {
            $id_pedido = $this->conn->insert_id;
            $query_item = "INSERT INTO " . $this->tabela_itens . " (fk_pedido_id, fk_variacao_produto_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)";
            $stmt_item = $this->conn->prepare($query_item);
            foreach ($itens as $item) {
                $stmt_item->bind_param("iiid", $id_pedido, $item['id_variacao'], $item['quantidade'], $item['preco']);
                $stmt_item->execute();
            }
            return $id_pedido;
        }
        return false;
    }

    // Método de cálculo de total vendido
    public function getTotalVendido()
    {
        $query = "SELECT SUM(total) as total_vendido FROM " . $this->tabela_pedido . " WHERE status = 'aprovado'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total_vendido'] ?? 0;
    }

    // Método de contagem de pedidos por status
    public function getContagemStatus()
    {
        $query = "SELECT status, COUNT(*) as qtd FROM " . $this->tabela_pedido . " GROUP BY status";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $dados = ['pendente' => 0, 'aprovado' => 0, 'rejeitado' => 0];
        while ($row = $result->fetch_assoc()) {
            $dados[$row['status']] = $row['qtd'];
        }
        return $dados;
    }
}
