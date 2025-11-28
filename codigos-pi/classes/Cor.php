<?php

class Cor
{
    private $conn;
    private $tabela_cor = "cor";
    public $id;
    public $nome;
    public $ativo;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Metodo de verificação de cor existente
    public function CorExiste()
    {
        $this->nome = trim($this->nome);

        if (!empty($this->id)) {
            $query = "SELECT id FROM " . $this->tabela_cor . " WHERE nome = ? AND id != ? LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si", $this->nome, $this->id);
        } else {
            $query = "SELECT id FROM " . $this->tabela_cor . " WHERE nome = ? LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $this->nome);
        }

        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }


    //Metodo de criação de cor
    public function criar()
    {
        $this->nome = trim($this->nome);

        if ($this->CorExiste()) {
            return false;
        }

        $query = "INSERT INTO " . $this->tabela_cor . " (nome) VALUES (?)";

        $stmt = $this->conn->prepare($query);
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $stmt->bind_param("s", $this->nome);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //Metodo de listagem de cores ativas
    public function listarAtivo()
    {
        $query = "SELECT * FROM " . $this->tabela_cor . " WHERE ativo = TRUE ORDER BY nome";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado;
    }

    //Metodo de listagem de cores inativas
    public function listarInativo()
    {
        $query = "SELECT * FROM " . $this->tabela_cor . " WHERE ativo = FALSE ORDER BY nome";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado;
    }

    //Metodo de exclusão de cor
    public function excluir()
    {
        $query = "DELETE FROM " . $this->tabela_cor . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    //Metodo verificação de cor em uso
    public function CorEmUso()
    {
        $query = "SELECT COUNT(*) as total_uso FROM variacao_produto WHERE fk_cor_id = ?";

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

    //Metodo de busca de cor usando id (apenas ativos)
    public function buscaID()
    {
        $query = "SELECT * FROM " . $this->tabela_cor . " WHERE id = ? and ativo = TRUE LIMIT 1";
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

    //Metodo de edição de cor
    public function editar()
    {
        $query = "UPDATE " . $this->tabela_cor . " SET nome = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $this->nome, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Metodo de inativação de cor soft delete
    public function inativar()
    {
        $query = "UPDATE " . $this->tabela_cor . " SET ativo = FALSE WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Metodo de reativação de cor
    public function reativar()
    {
        $query = "UPDATE " . $this->tabela_cor . " SET ativo = TRUE WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
