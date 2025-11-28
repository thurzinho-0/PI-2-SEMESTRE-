<?php

class Categoria
{

    private $conn;
    private $tabela_categoria = "categoria";
    public $nome;
    public $id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Metodo de verificação de categoria existente
    public function categoriaExiste()
    {
        $this->nome = trim($this->nome);

        if (!empty($this->id)) {
            $query = "SELECT id FROM " . $this->tabela_categoria .  " WHERE nome = ? AND id != ? LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si", $this->nome, $this->id);
        } else {
            $query = "SELECT id FROM " . $this->tabela_categoria . " WHERE nome = ? LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $this->nome);
        }

        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    //Metodo de criação de categoria
    public function criar()
    {
        $this->nome = trim($this->nome);

        if ($this->CategoriaExiste()) {
            return false;
        }

        $query = "INSERT INTO " . $this->tabela_categoria . " (nome) VALUES (?)";

        $stmt = $this->conn->prepare($query);
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $stmt->bind_param("s", $this->nome);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //Metodo de listagem de categoria
    public function listar()
    {
        $query = "SELECT * FROM " . $this->tabela_categoria . " WHERE ativo = TRUE ORDER BY nome";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado;
    }

    //Metodo de listagem de categorias inativas
    public function listarInativo()
    {
        $query = "SELECT * FROM " . $this->tabela_categoria . " WHERE ativo = FALSE ORDER BY nome";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado;
    }

    //Metodo de exclusão de categoria
    public function excluir()
    {
        $query = "DELETE FROM " . $this->tabela_categoria . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Metodo verificação de categoria em uso
    public function categoriaEmUso()
    {
        $query = "SELECT COUNT(*) as total_uso FROM produto_anuncio WHERE fk_categoria_id = ?";

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

    //Metodo de busca de categoria usando id
    public function buscaID()
    {
        $query = "SELECT * FROM " . $this->tabela_categoria . " WHERE id = ? LIMIT 1";
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

    //Metodo de edição de categoria
    public function editar()
    {
        $query = "UPDATE " . $this->tabela_categoria . " SET nome = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $this->nome, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Metodo de inativação de categoria soft delete
    public function inativar()
    {
        $query = "UPDATE " . $this->tabela_categoria . " SET ativo = FALSE WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Metodo de reativação de categoria
    public function reativar()
    {
        $query = "UPDATE " . $this->tabela_categoria . " SET ativo = TRUE WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
