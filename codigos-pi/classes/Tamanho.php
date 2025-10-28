<?php

class Tamanho
{
    private $conn;
    private $tabela_tamanho = "tamanho";
    public $id;
    public $nome;
    public $ativo;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Metodo de verificação de tamanho existente
    public function TamanhoExiste()
    {
        $query = "SELECT id FROM " . $this->tabela_tamanho . " WHERE nome = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->nome);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    //Metodo de criação de tamanho
    public function criar()
    {
        if ($this->TamanhoExiste()) {
            return false;
        }

        $query = "INSERT INTO " . $this->tabela_tamanho . " (nome) VALUES (?)";

        $stmt = $this->conn->prepare($query);
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $stmt->bind_param("s", $this->nome);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //Metodo de listagem de tamanho ativos
    public function listarAtivo()
    {
        $query = "SELECT * FROM " . $this->tabela_tamanho . " WHERE ativo = TRUE ORDER BY nome";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado;
    }

    //Metodo de listagem de tamanhos inativos
    public function listarInativo()
    {
        $query = "SELECT * FROM " . $this->tabela_tamanho . " WHERE ativo = FALSE ORDER BY nome";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado;
    }

    //Metodo de exclusão de tamanho
    public function excluir()
    {
        $query = "DELETE FROM " . $this->tabela_tamanho . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    //Metodo verificação de tamanho em uso
    public function TamanhoEmUso()
    {
        $query = "SELECT COUNT(*) as total_uso FROM variacao_produto WHERE fk_tamanho_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();

        if ($resultado['total_uso'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    //Metodo de busca de tamanho usando id (apenas ativos)
    public function buscaID()
    {
        $query = "SELECT * FROM " . $this->tabela_tamanho . " WHERE id = ? and ativo = TRUE LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows == 1) {
            $row = $res->fetch_assoc();
            return $row;
        }
        return false;
    }

    //Metodo de edição de tamanho
    public function editar()
    {
        $query = "UPDATE " . $this->tabela_tamanho . " SET nome = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $this->nome, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Metodo de inativação de tamanho soft delete
    public function inativar()
    {
        $query = "UPDATE " . $this->tabela_tamanho . " SET ativo = FALSE WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
